<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Cartes\AbstractCarte;

class Stub extends AbstractCarte
{
    private
        $value;

    public function __construct(Joueur $joueur, int $value)
    {
        parent::__construct($joueur);

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
