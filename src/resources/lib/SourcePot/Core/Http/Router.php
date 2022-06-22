<?php

namespace SourcePot\Core\Http;

use SourcePot\Core\Controller\ControllerInterface;

class Router implements RouterInterface
{
    private array $controllers = [];

    public static function create(): self
    {
        return new self;
    }

    public function getControllerForRoute(string $path): ControllerInterface
    {
        foreach($this->controllers as $pathRegex => $controllerClass) {
            $matches = [];
            preg_match('#^'.$pathRegex.'$#', $path, $matches);
            if(sizeof($matches) > 0) {
                /**
                 * $matches array contains:
                 *  0: the pattern that matched (i.e. the pattern because there is a match)
                 *  1... each capture group in the regex
                 * 
                 * We don't care about the pattern that matched, we know that already
                 */
                array_shift($matches);

                // Pass the capture groups into the controller's create method
                $controller = $controllerClass::create(...$matches);

                if(!$controller instanceof ControllerInterface) {
                    throw new Exception\InvalidControllerClass($controllerClass);
                }

                return $controller;
            }
        }

        throw new Exception\NoRouteForPathException($path);
    }

    public function addRoutes(array $routes): self
    {
        foreach($routes as $path => $controller) {
            $this->controllers[$path] = $controller;
        }

        return $this;
    }
}