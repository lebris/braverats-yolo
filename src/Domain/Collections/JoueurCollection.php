<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Collections;

use BraveRats\Domain\Joueur;

class JoueurCollection implements \IteratorAggregate, \Countable
{
    private
        $joueurs;

    public function __construct($joueur1, $joueur2)
    {
        $this->joueurs = [];

        foreach([$joueur1, $joueur2] as $joueur)
        {
            if($joueur instanceof Joueur)
            {
                $this->add($joueur);
            }
        }
    }

    private function add(Joueur $joueur): self
    {
        $this->joueurs[] = $joueur;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->joueurs);
    }

    public function count(): int
    {
        return count($this->joueurs);
    }
}
