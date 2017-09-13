<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Joueur;
use BraveRats\Domain\Collections\CarteCollection;

class Memory implements Joueur
{
    private
        $name,
        $cartes;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->cartes = new CarteCollection($this);
    }

    public function cartes(): CarteCollection
    {
        return $this->cartes;
    }
}
