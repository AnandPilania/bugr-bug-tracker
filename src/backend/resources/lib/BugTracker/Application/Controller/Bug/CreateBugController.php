<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Bug\CreateBugCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Persistence\DatabaseAdapter;

class CreateBugController implements ControllerInterface
{
    public User $user;

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        // @todo create validator to check that these are not empty
        if (!$params->has('title') || !$params->has('project') || !$params->get('status')) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $database = Container::get(DatabaseAdapter::class);

        $database->command(new CreateBugCommand(
            $params->get('title'),
            $params->get('project'),
            $params->get('status')
        ));

        return (new BasicResponse())
            ->setBody('Bug created');
    }

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new LoggedInUserRequiredStrategy($entity);
    }
}
