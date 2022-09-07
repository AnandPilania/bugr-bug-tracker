<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Session\RealSession;
use SourcePot\Core\Http\Session\Session;
use SourcePot\Security\Password;

class LoginController implements ControllerInterface
{
    public function accessCode(): string
    {
        return '';
    }

    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('username') || !$params->has('password')) {
            return (new RedirectResponse())->setBody('/login/error');
        }

        $username = $params->get('username');
        $password = $params->get('password');

        // query database with username/password to check user exists
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user === false) {
            return (new RedirectResponse())->setBody('/login/error');
        }

        $valid_password = Password::validate($password, $user['password']);
        if ($valid_password === false) {
            return (new RedirectResponse())->setBody('/login/error');
        }

        $session = new Session(new RealSession());
        $session->store('jwt', $token);

        if ($params->has('target-page')) {
            return (new RedirectResponse())->setBody($params->get('target-page'));
        }

        $params = print_r($user, true);
        return (new BasicResponse())
            ->setHeader('content-type', 'text/plain')
            ->setBody($params);
    }
}
