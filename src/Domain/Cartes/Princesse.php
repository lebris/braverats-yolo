<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Princesse extends AbstractCarte
{
    public const
        VALUE = 1;

    public function value(): int
    {
        return self::VALUE;
    }
}
