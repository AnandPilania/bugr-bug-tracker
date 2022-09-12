<?php

namespace SourcePot\Core;

use JsonException;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\Response\UnauthenticatedResponse;
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
    private Config $config;
    private readonly ListenerProvider $listenerProvider;

    public function __construct()
    {
        $this->listenerProvider = new ListenerProvider();
    }

    public function loadConfig(string $configFilename): self
    {
        // Load configuration and setup dependency injection container
        try {
            $this->config = new Config();
            $this->config->setMany(FileLoader::loadJsonFromFile($configFilename));
            Container::put($this->config);
        } catch (JsonException $e) {
            http_response_code(500);
            echo "Error loading site config, cannot service requests ({$e->getMessage()}";
            exit;
        }

        return $this;
    }

    protected function setupListeners(): void
    {
        foreach ($this->config->get('listeners') as $listenerObject) {
            try {
                [$eventName, $listenerClass] = $listenerObject;
                $this->listenerProvider->registerListenerForEvent(
                    $eventName,
                    $listenerClass
                );
            } catch (\Throwable $t) {
                // @todo do we want to do anything else with this error?
                error_log($t->getMessage());
            }
        }
    }

    public function execute(): void
    {
        // These parts cannot fail
        $eventDispatcher = new EventDispatcher($this->listenerProvider);
        $this->setupListeners();

        try {
            $eventDispatcher->dispatch(new CoreStartedEvent());

            $router = Router::create();
            $router->addRoutes($this->config->get('routes'));

            $request = Request::create();
            $controller = $router->getControllerForRoute($request->path(), $request->method());

            $eventDispatcher->dispatch(new RouteDecidedEvent($request, $controller));

            $eventDispatcher->dispatch(new RequestStartedEvent());
            $response = $controller->execute($request);
            $eventDispatcher->dispatch(new RequestFinishedEvent());
            $response->send();
        } catch (Http\Exception\NoRouteForPathException $e) {
            ErrorResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (Http\Exception\UnauthorisedException $e) {
            UnauthenticatedResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (Http\Exception\UnauthenticatedException $e) {
            UnauthorisedResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (\Throwable $t) {
            ErrorResponse::create()
                ->setBody('ERROR: ' . $t::class . "\n" . $t->getMessage())
                ->send();
        } finally {
            $eventDispatcher->dispatch(new CoreShutdownEvent());
        }
    }
}
