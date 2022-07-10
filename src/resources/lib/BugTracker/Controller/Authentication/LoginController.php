<?php

namespace BugTracker\Controller\Authentication;

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\RedirectResponse;
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
        $params = $request->params();
        
        if(!$params->has('username') || !$params->has('password')) {
            return new RedirectResponse('/login/error');
        }

        $username = $params->get('username');
        $password = $params->get('password');

        // query database with username/password to check user exists
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $query = new FindUserByUsernameQuery($username);
        $user = $query->execute($database);

        if($user === false) {
            return new RedirectResponse('/login/error');
        }

        $valid_password = password_verify($password, $user['password']);
        if($valid_password === false) {
            return new RedirectResponse('/login/error');
        }

        $token = new JWT($user);
        Session::store('login-token', $token);

        if($params->has('target_page')) {
            return new RedirectResponse($params->get('target-page'));
        }
        
        $params = print_r($user,true);
        return (new BasicResponse)
            ->setHeader('content-type', 'text/plain')
            ->setBody($params);
    }
}
