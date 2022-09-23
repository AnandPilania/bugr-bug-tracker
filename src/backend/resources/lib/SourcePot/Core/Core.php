<?php

namespace SourcePot\Core;

use BugTracker\Application\Persistence\CommandBusInterface;
use BugTracker\Application\Persistence\QueryBusInterface;
use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\CommandBus;
use BugTracker\Persistence\QueryBus;
use JsonException;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\EventDispatcher\EventDispatcherInterface;
use SourcePot\Core\EventDispatcher\EventInterface;
use SourcePot\Core\Http\Response\NotFoundResponse;
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
use SourcePot\Core\Http\RouterInterface;
use SourcePot\IO\FileLoader;
use SourcePot\Persistence\DatabaseAdapter;

class Core implements CoreInterface
{
    private Config $config;
    private ListenerProvider $listenerProvider;
    private EventDispatcherInterface $eventDispatcher;
    private RouterInterface $router;

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

    private function setupEventDispatcher(): void
    {
        $this->eventDispatcher = new EventDispatcher($this->listenerProvider);
        $this->setupListeners();
    }

    private function dispatchEvent(EventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    private function initiateDatabaseConnection(): void
    {
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        Container::put($database);
    }

    public function setupCommandBus(): void
    {
        $commandBus = new CommandBus(Container::get(DatabaseAdapter::class));
        Container::put($commandBus, CommandBusInterface::class);
    }

    private function setupQueryBus(): void
    {
        $queryBus = new QueryBus(Container::get(DatabaseAdapter::class));
        Container::put($queryBus, QueryBusInterface::class);
    }

    private function setupRoutes(): void
    {
        $this->router = Router::create();
        $this->router->addRoutes($this->config->get('routes'));
    }

    public function execute(): void
    {
        try {
            $this->setupEventDispatcher();
            $this->initiateDatabaseConnection();
            $this->setupCommandBus();
            $this->setupQueryBus();

            $this->dispatchEvent(new CoreStartedEvent());

            $this->setupRoutes();

            $request = Request::create();
            $controller = $this->router->getControllerForRoute($request->path(), $request->method());

            $this->dispatchEvent(new RouteDecidedEvent($request, $controller));

            $this->dispatchEvent(new RequestStartedEvent());
            $response = $controller->execute($request);
            $this->dispatchEvent(new RequestFinishedEvent());
            $response->send();
        } catch (Http\Exception\NoRouteForPathException $e) {
            NotFoundResponse::create()
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
            $this->dispatchEvent(new CoreShutdownEvent());
        }
    }
}
