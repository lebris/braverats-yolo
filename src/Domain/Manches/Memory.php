<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Manche;
use BraveRats\Domain\Cartes\Prince;
use BraveRats\Domain\Cartes\General;
use BraveRats\Domain\Cartes\Assassin;
use BraveRats\Domain\Cartes\Magicien;
use BraveRats\Domain\Cartes\Musicien;
use BraveRats\Domain\Cartes\Princesse;
use BraveRats\Domain\Cartes\Ambassadeur;
use BraveRats\Domain\Cartes\Modificateurs\BonusFromGeneral;
use BraveRats\Domain\Manches\Exceptions\Draw;
use BraveRats\Domain\Manches\Exceptions\Solved;
use BraveRats\Domain\Manches\Exceptions\EndOfGame;

class Memory implements Manche
{
    private
        $scoreManche,
        $scoreParJoueur,
        $modeAssassin;

    public function __construct(int $scoreManche = 1)
    {
        $this->scoreManche = $scoreManche;
        $this->scoreParJoueur = [];
        $this->modeAssassin = false;
    }

    public function resolve(Carte $carte1, Carte $carte2): ?Joueur
    {
        try
        {
            $this->tryMusicien($carte1, $carte2);
            $this->checkPrincesse($carte1, $carte2);
            $this->checkPrince($carte1, $carte2);
            $this->checkAssassin($carte1, $carte2);
        }
        catch(Solved $exception)
        {
            return $exception->result();
        }

        $r = $this->resolveByValue($carte1, $carte2);

        $this->handleNextGeneral($carte1, $carte2);

        return $r;
    }

    public function score(): int
    {
        return $this->scoreManche;
    }

    public function nextMancheFromDraw(): Manche
    {
        return new self($this->score() + 1);
    }

    public function nextMancheFromVictory(): Manche
    {
        return new self();
    }

    private function handleNextGeneral(Carte $carte1, Carte $carte2): void
    {
        foreach([$carte1, $carte2] as $carte)
        {
            if($carte->is(General::VALUE) && !$carte2->is(Magicien::VALUE))
            {
                $carte->joueur()->addBonusForNextManche(new BonusFromGeneral());
            }
        }
    }

    private function checkPrince(Carte $carte1, Carte $carte2)
    {
        if($carte1->is(Prince::VALUE) && $carte2->is(Prince::VALUE))
        {
            throw new Draw();
        }

        if($carte1->is(Prince::VALUE) && !$carte2->is(Princesse::VALUE))
        {
            throw new Solved($carte1->joueur());
        }

        if($carte2->is(Prince::VALUE) && !$carte1->is(Princesse::VALUE))
        {
            throw new Solved($carte2->joueur());
        }
    }

    private function checkPrincesse(Carte $carte1, Carte $carte2)
    {
        if($carte1->is(Prince::VALUE) && $carte2->is(Princesse::VALUE))
        {
            throw new EndOfGame($carte2->joueur());
        }

        if($carte1->is(Princesse::VALUE) && $carte2->is(Prince::VALUE))
        {
            throw new EndOfGame($carte1->joueur());
        }
    }

    private function tryMusicien(Carte $carte1, Carte $carte2)
    {
        if($carte1->is(Musicien::VALUE) && ! $carte2->is(Magicien::VALUE))
        {
            throw new Draw();
        }

        if($carte2->is(Musicien::VALUE) && ! $carte1->is(Magicien::VALUE))
        {
            throw new Draw();
        }
    }

    private function checkAssassin(Carte $carte1, Carte $carte2)
    {
        if($carte1->is(Assassin::VALUE) || $carte2->is(Assassin::VALUE))
        {
            if($carte1->is(Magicien::VALUE) || $carte2->is(Magicien::VALUE))
            {
                return;
            }

            $this->modeAssassin = true;
        }
    }

    private function resolveByValue(Carte $carte1, Carte $carte2): ?Joueur
    {
        if($carte1->computeValueWithModificateurs() === $carte2->computeValueWithModificateurs())
        {
            return null;
        }

        if(false === $this->modeAssassin)
        {
            if($carte1->computeValueWithModificateurs() > $carte2->computeValueWithModificateurs())
            {
                return $carte1->joueur();
            }

            return $carte2->joueur();
        }

        if($carte1->computeValueWithModificateurs() < $carte2->computeValueWithModificateurs())
        {
            return $carte1->joueur();
        }

        return $carte2->joueur();
    }
}
