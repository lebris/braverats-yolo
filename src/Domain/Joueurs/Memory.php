<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Manche;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Cartes\Modificateur;
use BraveRats\Domain\Collections\CarteCollection;

class Memory implements Joueur
{
    private
        $name,
        $cartes,
        $score,
        $modificateursNextManche,
        $modificateursCurrentManche;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->cartes = new CarteCollection($this);
        $this->score = 0;
        $this->modificateursNextManche = [];
        $this->modificateursCurrentManche = [];
    }

    public function cartes(): CarteCollection
    {
        return $this->cartes;
    }

    public function gagne(Manche $manche): void
    {
        $this->score += $manche->score($this);
    }

    public function score(): int
    {
        return $this->score;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function modificateursCurrentManche(): array
    {
        return $this->modificateursCurrentManche;
    }

    public function addBonusForNextManche(Modificateur $modificateur): void
    {
        $this->modificateursNextManche[] = $modificateur;
    }

    public function initializeNewManche()
    {
        $this->modificateursCurrentManche = $this->modificateursNextManche;
        $this->modificateursNextManche = [];
    }
}
