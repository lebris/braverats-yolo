<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Parties;

use BraveRats\Domain\Partie;
use BraveRats\Infrastructure\IO;
use BraveRats\Domain\Collections\JoueurCollection;

class Memory implements Partie
{
    private
        $io,
        $joueurs;

    public function __construct(IO $io, JoueurCollection $joueurs)
    {
        $this->io = $io;
        $this->joueurs = $joueurs;
    }

    public function play()
    {
        $manche = new Manche();

        $cartes = [];
        foreach($this->joueurs as $joueur)
        {
            $cartes[] = $io->getCarteJouee($joueur);
        }

        list($carte1, $carte2) = $cartes;

        $manche->resolve($carte1, $carte2);

        // demander cartes aux joueurs
        // résoudre la manche
        // manche suivante
    }
}
