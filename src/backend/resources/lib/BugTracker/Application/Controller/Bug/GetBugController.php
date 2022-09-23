<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Application\Persistence\QueryBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Bug\GetBugQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class GetBugController implements ControllerInterface
{
    private QueryBusInterface $queryBus;

    public function __construct(
        private int $bugId
    ) {
        $this->queryBus = Container::get(QueryBusInterface::class);
    }

    public static function create(...$args): self
    {
        [$bugIdStr] = $args;

        if (!is_numeric($bugIdStr)) {
            throw new InvalidArgumentException("Bug ID {$bugIdStr} is not numeric!");
        }

        $bugId = (int) $bugIdStr;

        return new self($bugId);
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $bug = $this->queryBus->handle(new GetBugQuery($this->bugId));

        return (new JSONResponse())
            ->setBody($bug->toArray());
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
