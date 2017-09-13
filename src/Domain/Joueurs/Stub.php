<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Joueur;
use BraveRats\Domain\Cartes\Modificateur;
use BraveRats\Domain\Collections\CarteCollection;

class Stub implements Joueur
{
    public
        $nextModificateurs,
        $modificateursNextManche,
        $modificateursCurrentManche;

    public function __construct()
    {
        $this->modificateursNextManche = [];
        $this->modificateursCurrentManche = [];
        $this->nextModificateurs = [];
    }

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

    public function addBonusForNextManche(Modificateur $modificateur): void
    {
        $this->modificateursNextManche[] = $modificateur;
    }

    public function modificateursCurrentManche(): array
    {
        return $this->modificateursCurrentManche;
    }

    public function initializeNewManche()
    {
        $this->modificateursCurrentManche = $this->modificateursNextManche;
        $this->modificateursNextManche = [];
    }
}
