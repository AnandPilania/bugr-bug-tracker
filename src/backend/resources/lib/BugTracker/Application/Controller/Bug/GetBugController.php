<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use InvalidArgumentException;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;

class GetBugController implements ControllerInterface
{
    public function authorise(?User $user): bool
    {
        return $user !== null;
    }

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
        return (new BasicResponse())
            ->setHeader('content-type', 'text/plain')
            ->setBody(get_debug_type($this->bugId) . '(' . $this->bugId . ')');
    }
}
