<?php

namespace BugTracker\Controller\Authentication;

use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\TemplateEngine\Template;

class LoginController implements ControllerInterface
{
    public function accessCode(): string
    {
        return '';
    }

    public static function create(...$args): self
    {
        return new self;
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        // todo
        // check params has username
        // check params has password
        // query database with username/password to check user exists
        // populate JWT with access
        // store JWT in session
        // redirect to previous page (if populated), otherwise index (/)
        
        $params = print_r($request->params(),true);
        return (new BasicResponse)
            ->setHeader('content-type', 'text/plain')
            ->setBody($params);
    }
}
