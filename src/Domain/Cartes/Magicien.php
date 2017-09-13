<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Magicien extends AbstractCarte
{
    public const
        VALUE = 5;

    public function value(): int
    {
        return self::VALUE;
    }
}
