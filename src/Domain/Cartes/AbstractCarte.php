<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;

abstract class AbstractCarte implements Carte
{
    private
        $joueur;

    public function __construct(Joueur $joueur)
    {
        $this->joueur = $joueur;
    }

    public function joueur(): Joueur
    {
        return $this->joueur;
    }
}
