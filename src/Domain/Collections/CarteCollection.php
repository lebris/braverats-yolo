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
            'Ambassadeur' => new Ambassadeur($joueur),
            'Assassin' => new Assassin($joueur),
            'Espion' => new Espion($joueur),
            'General' => new General($joueur),
            'Magicien' => new Magicien($joueur),
            'Musicien' => new Musicien($joueur),
            'Prince' => new Prince($joueur),
            'Princesse' => new Princesse($joueur),
        ];
    }

    public function getByName(string $name): ?Carte
    {
        if(! array_key_exists($name, $this->cartes))
        {
            return null;
        }

        $carte = $this->cartes[$name];

        unset($this->cartes[$name]);

        return $carte;
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
