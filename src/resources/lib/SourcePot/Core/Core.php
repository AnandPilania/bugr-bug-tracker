<?php

namespace SourcePot\Core;

use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\UnauthorisedResponse;
use SourcePot\Core\Http\Request;
use SourcePot\Core\Http\Router;
use SourcePot\Core\Event\CoreStartedEvent;
use SourcePot\Core\Event\CoreShutdownEvent;
use SourcePot\Core\Event\RequestFinishedEvent;
use SourcePot\Core\Event\RequestStartedEvent;
use SourcePot\Core\Event\RouteDecidedEvent;
use SourcePot\Core\EventDispatcher\EventDispatcher;
use SourcePot\Core\EventDispatcher\ListenerProvider;
use SourcePot\IO\FileLoader;

class Core implements CoreInterface
{
    private readonly ListenerProvider $listenerProvider;

    public function __construct()
    {
        $this->listenerProvider = new ListenerProvider();
    }

    public function execute(): void
    {
        try {
            $config = Container::get(Config::class);

            $eventDispatcher = new EventDispatcher($this->listenerProvider);

            foreach ($config->get('listeners') as $listenerObject) {
                [$eventName, $listenerClass] = $listenerObject;
                $this->listenerProvider->registerListenerForEvent(
                    $eventName,
                    $listenerClass
                );
            }

            $eventDispatcher->dispatch(new CoreStartedEvent());

            $router = Router::create();
            $router->addRoutes($config->get('routes'));

            $request = Request::create();
            $controller = $router->getControllerForRoute($request->path(), $request->method());

            $eventDispatcher->dispatch(new RouteDecidedEvent($request, $controller));

            $eventDispatcher->dispatch(new RequestStartedEvent());
            $response = $controller->execute($request);
            $eventDispatcher->dispatch(new RequestFinishedEvent());
            $response->send();

            $eventDispatcher->dispatch(new CoreShutdownEvent());
        } catch (Http\Exception\NoRouteForPathException $e) {
            ErrorResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (Http\Exception\UnauthorisedException $e) {
            UnauthorisedResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (Http\Exception\ForbiddenException $e) {
            UnauthorisedResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (\Throwable $t) {
            ErrorResponse::create()
                ->setBody('ERROR: ' . $t::class . "\n" . $t->getMessage())
                ->send();
        }
    }
}
