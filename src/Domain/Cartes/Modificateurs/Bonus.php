<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Modificateurs;

use BraveRats\Domain\Carte;

class Bonus
{
    private
        $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function apply(Carte $carte): int
    {
        return $carte->value() + $this->value;
    }
}
