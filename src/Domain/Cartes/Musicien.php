<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Musicien extends AbstractCarte
{
    public const
        VALUE = 0;

    public function value(): int
    {
        return self::VALUE;
    }
}
