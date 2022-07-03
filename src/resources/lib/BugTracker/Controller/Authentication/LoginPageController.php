<?php

namespace BugTracker\Controller\Authentication;

use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\HTMLResponse;
use SourcePot\TemplateEngine\TemplateEngine;

class LoginPageController implements ControllerInterface
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
        TemplateEngine::setBaseDirectory(dirname($_SERVER['DOCUMENT_ROOT']).'/resources/template');
        $template = TemplateEngine::loadFromFile('pages/login.tpl');
        $template->parse(['page-title' => 'Log in']);
        return (new HTMLResponse())->setBody(
            $template->render()
        );
    }
}
