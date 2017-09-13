<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes\Modificateurs;

use BraveRats\Domain\Cartes\Modificateur;

class BonusFromGeneral implements Modificateur
{
    public function apply(int $value): int
    {
        return $value + 2;
    }
}
