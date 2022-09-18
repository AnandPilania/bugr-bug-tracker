<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Bug\GetBugQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Persistence\DatabaseAdapter;

class GetBugController implements ControllerInterface
{
    public function __construct(
        private int $bugId
    ) {
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
        $database = Container::get(DatabaseAdapter::class);

        $bug = $database->query(new GetBugQuery($this->bugId));

        return (new JSONResponse())
            ->setBody($bug->toArray());
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
