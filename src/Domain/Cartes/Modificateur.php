<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Carte;

interface Modificateur
{
    public function apply(int $value): int;
}
