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
    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        // @todo create validator to check that these are not empty
        if (
            !$params->has('title') ||
            !$params->has('description') ||
            !$params->has('project') ||
            !$params->get('status')
        ) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $database = Container::get(DatabaseAdapter::class);

        $database->command(new CreateBugCommand(
            title: $params->get('title'),
            description: $params->get('description'),
            projectId: (int)$params->get('project'),
            statusId: (int)$params->get('status')
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
        return new LoggedInUserRequiredStrategy($entity);
    }
}
