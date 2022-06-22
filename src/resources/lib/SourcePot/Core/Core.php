<?php

namespace SourcePot\Core;

use BugTracker\Listener\OutputAutoloaderClassesHandler;
use SourcePot\Core\Config\StorageConfig as Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Request;
use SourcePot\Core\Http\Router;
use SourcePot\Core\Event\CoreStartedEvent;
use SourcePot\Core\Event\CoreShutdownEvent;
use SourcePot\Core\Event\RequestFinishedEvent;
use SourcePot\Core\Event\RequestStartedEvent;
use SourcePot\Core\EventDispatcher\EventDispatcher;
use SourcePot\Core\EventDispatcher\ListenerProvider;
use SourcePot\IO\FileLoader;

class Core implements CoreInterface
{
    private readonly string $configFile;

    public function __construct()
    {
        $this->configFile = dirname($_SERVER['DOCUMENT_ROOT']).'/config.json';
    }

    public static function create(): self
    {
        return new self;
    }

    public function execute(): void
    {
        try {
            $listenerProvider = new ListenerProvider;
            
            // todo load some global settings/config
            // todo refactor how config is stored and loaded
            $config = new Config(Storage::instance());
            $config->load(FileLoader::loadJsonFromFile($this->configFile),true);
            $eventDispatcher = new EventDispatcher($listenerProvider);

            foreach($config->get('listeners') as $listenerObject) {
                [$eventName, $listenerClass] = $listenerObject;
                $listenerProvider->registerListenerForEvent(
                    $eventName,
                    $listenerClass
                );
            }

            $eventDispatcher->dispatch(new CoreStartedEvent);

            $request = Request::create();

            $router = Router::create();
            $router->addRoutes($config->get('routes'));

            $controller = $router->getControllerForRoute($request->path());

            $eventDispatcher->dispatch(new RequestStartedEvent);
            $response = $controller->execute($request);
            $eventDispatcher->dispatch(new RequestFinishedEvent);
            $response->send();

            $eventDispatcher->dispatch(new CoreShutdownEvent);

        } catch(Http\Exception\NoRouteForPathException $e) {
            ErrorResponse::create()
                ->setBody($e->getMessage())
                ->send();
        } catch (\Throwable $t) {
            ErrorResponse::create()
                ->setBody('ERROR: ' . $t::class . "\n" . $t->getMessage())
                ->send();
        }
    }
}
