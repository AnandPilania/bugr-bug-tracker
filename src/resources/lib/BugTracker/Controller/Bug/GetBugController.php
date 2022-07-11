<?php

namespace BugTracker\Controller\Bug;

use InvalidArgumentException;
use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;

class GetBugController implements ControllerInterface
{
    public function accessCode(): string
    {
        return 'bug.load';
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
