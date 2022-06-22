<?php

namespace SourcePot\Core;

use SourcePot\Core\Config\StorageConfig as Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\Core\Http\ErrorResponse;
use SourcePot\Core\Http\Request;
use SourcePot\Core\Http\Router;
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
            // todo fire some events
            // todo load some global settings/config
            $config = new Config(Storage::instance());
            $config->load(FileLoader::loadJsonFromFile($this->configFile),true);

            $request = Request::create();

            $router = Router::create();
            $router->addRoutes($config->get('routes'));

            $controller = $router->getControllerForRoute($request->path());

            $response = $controller->execute($request);

            $response->send();

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
