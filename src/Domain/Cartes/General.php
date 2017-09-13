<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

class General extends AbstractCarte
{
    public const
        VALUE = 6;

    public function value(): int
    {
        return self::VALUE;
    }
}
