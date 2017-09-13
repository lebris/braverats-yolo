<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Parties;

use BraveRats\Domain\Joueur;
use BraveRats\Domain\Partie;
use BraveRats\Domain\Manches\Memory as Manche;
use BraveRats\Domain\Manches\Exceptions\EndOfGame;
use BraveRats\Infrastructure\IO;
use BraveRats\Domain\Collections\JoueurCollection;

class Memory implements Partie
{
    private const
        VICTORY_POINT_TRIGGER = 4;

    private
        $io,
        $joueurs,
        $winner;

    public function __construct(IO $io, JoueurCollection $joueurs)
    {
        $this->io = $io;
        $this->joueurs = $joueurs;
        $this->winner = null;
    }

    public function play()
    {
        $manche = new Manche();
        while(! $this->isEnded())
        {
            list($carte1, $carte2) = $this->getCartesjouee();

            try
            {
                $winner = $manche->resolve($carte1, $carte2);

                $this->io->output('-----------------------------------------------');
                $this->io->output(sprintf('Fin de manche'));

                if($winner instanceof Joueur)
                {
                    $winner->gagne($manche);

                    $this->io->output(sprintf('Winner is : %s', $winner->name()));
                    $this->io->output('-----------------------------------------------');
                    $this->io->output('Score');

                    foreach($this->joueurs as $joueur)
                    {
                        $this->io->output(sprintf('%s : %s', $joueur->name(), $joueur->score()));
                    }

                    $manche = $manche->nextMancheFromVictory();
                }
                else
                {
                    $manche = $manche->nextMancheFromDraw();
                    $this->io->output(sprintf('Egalité'));
                }
                $this->io->output('-----------------------------------------------');

                $this->computeWinner();
            }
            catch(EndOfGame $e)
            {
                $this->winner = $e->result();
            }
        }

        $this->hourray();
    }

    private function isEnded()
    {
        if($this->winner instanceof Joueur)
        {
            return true;
        }

        foreach($this->joueurs  as $joueur)
        {
            if(count($joueur->cartes()) == 0)
            {
                throw new \LogicException(sprintf('Le joueur %s n\'a plus de cartes', $joueur->name()));
            }
        }
    }

    private function computeWinner()
    {
        foreach($this->joueurs as $joueur)
        {
            if($joueur->score() >= self::VICTORY_POINT_TRIGGER)
            {
                $this->winner = $joueur;
            }
        }
    }

    public function winner(): ?Joueur
    {
        return $this->winner;
    }

    private function getCartesJouee(): array
    {
        $cartes = [];
        foreach($this->joueurs as $joueur)
        {
            $nomCarte = $this->io->getCarteJouee($joueur);

            $carte = $joueur->cartes()->getByName($nomCarte);

            $cartes[] = $carte;
        }

        return $cartes;
    }

    private function hourray()
    {
        $this->io->output('');
        $this->io->output('');
        $this->io->output('###################################################');
        $this->io->output(sprintf('Joueur "%s" a gagné', $this->winner->name()));

        $this->io->output(<<<TXT
         _
        /(|
       (  :
      __\  \  _____
    (____)  `|
   (____)|   |
    (____).__|
     (___)__.|_____
TXT
        );
    }
}
