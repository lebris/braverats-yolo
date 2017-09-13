<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Espion extends AbstractCarte
{
    public const
        VALUE = 2;

    public function value(): int
    {
        return self::VALUE;
    }
}
