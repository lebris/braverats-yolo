<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Joueur;
use BraveRats\Domain\Cartes\Modificateur;
use BraveRats\Domain\Collections\CarteCollection;

class NullJoueur implements Joueur
{
    public function score(): int
    {
    }

    public function cartes(): \BraveRats\Domain\Collections\CarteCollection
    {
        return new CarteCollection();
    }

    public function gagne(\BraveRats\Domain\Manche $manche): void
    {
    }

    public function name(): string
    {
        return '';
    }

    public function modificateursCurrentManche(): array
    {
        return [];
    }

    public function addBonusForNextManche(Modificateur $modificateur): void
    {
    }
}
