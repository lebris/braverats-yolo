<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Modificateurs;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Modificateur;

class NullModificateur implements Modificateur
{
    public function apply(Carte $carte)
    {
        return $carte->value();
    }
}
