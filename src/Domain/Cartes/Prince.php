<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Prince extends AbstractCarte
{
    public const
        VALUE = 7;

    public function value(): int
    {
        return self::VALUE;
    }
}
