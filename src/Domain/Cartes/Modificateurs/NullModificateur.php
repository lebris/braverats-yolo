<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Modificateurs;

use BraveRats\Domain\Cartes\Modificateur;

class NullModificateur implements Modificateur
{
    public function apply(int $value)
    {
        return $value;
    }
}
