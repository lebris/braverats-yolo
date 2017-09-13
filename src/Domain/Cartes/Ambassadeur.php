<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class Ambassadeur extends AbstractCarte
{
    public const
        VALUE = 4;

    public function value(): int
    {
        return self::VALUE;
    }
}
