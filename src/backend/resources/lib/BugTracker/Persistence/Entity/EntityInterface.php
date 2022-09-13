<?php

namespace BugTracker\Persistence\Entity;

interface EntityInterface
{
    public static function populate(array $args): static;

    public function toArray(): array;
}
