<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Project\DeleteProjectCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DeleteProjectController implements ControllerInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public static function create(...$args): ControllerInterface
    {
        [$projectIdStr] = $args;

        if (!is_numeric($projectIdStr)) {
            throw new InvalidArgumentException("Bug ID {$projectIdStr} is not numeric!");
        }

        $projectId = (int) $projectIdStr;

        return new self($projectId);
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $database = Container::get(DatabaseAdapter::class);

        $database->command(new DeleteProjectCommand($this->projectId));

        return (new BasicResponse())
            ->setBody('Project deleted');
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new AdminUserRequiredStrategy($entity);
    }
}
