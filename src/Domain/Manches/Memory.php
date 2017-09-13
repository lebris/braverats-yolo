<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Manche;

class Memory implements Manche
{
    public function resolve(Carte $carte1, Carte $carte2): ?Joueur
    {
        return $this->resolveByValue($carte1, $carte2);
    }

    private function resolveByValue(Carte $carte1, Carte $carte2): ?Joueur
    {
        if($carte1->value() === $carte2->value())
        {
            return null;
        }

        if($carte1->value() > $carte2->value())
        {
            return $carte1->joueur();
        }

        return $carte2->joueur();
    }
}
