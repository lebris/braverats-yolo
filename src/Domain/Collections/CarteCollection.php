<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Collections;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Cartes\Espion;
use BraveRats\Domain\Cartes\General;
use BraveRats\Domain\Cartes\Magicien;
use BraveRats\Domain\Cartes\Musicien;
use BraveRats\Domain\Cartes\Assassin;
use BraveRats\Domain\Cartes\Prince;
use BraveRats\Domain\Cartes\Princesse;
use BraveRats\Domain\Cartes\Ambassadeur;

class CarteCollection implements \IteratorAggregate, \Countable
{
    private
        $cartes;

    public function __construct(Joueur $joueur)
    {
        $this->cartes = [
            new Ambassadeur($joueur),
            new Assassin($joueur),
            new Espion($joueur),
            new General($joueur),
            new Magicien($joueur),
            new Musicien($joueur),
            new Prince($joueur),
            new Princesse($joueur),
        ];
    }

    public function add(Carte $carte): self
    {
        $this->cartes[] = $carte;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->cartes);
    }

    public function count(): int
    {
        return count($this->cartes);
    }
}
