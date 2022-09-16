<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Project\GetProjectQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\NotFoundResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class GetSingleProjectController implements ControllerInterface
{
    public function __construct(private readonly int $projectId)
    {
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

        $project = $database->query(new GetProjectQuery($this->projectId));

        if ($project === false) {
            return (new NotFoundResponse())
                ->setBody('The requested resource could not be located');
        }

        return (new JSONResponse())
            ->setBody($project);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
