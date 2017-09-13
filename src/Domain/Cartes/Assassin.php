<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;

class Assassin extends AbstractCarte
{
    public const
        VALUE = 3;

    public function value(): int
    {
        return self::VALUE;
    }

    //
    // private
    //     $modificateur;
    //
    // public function __construct()
    // {
    //     $this->modificateur = new NullModificateur();
    // }
    //
    // public function addModificateur(Modificateur $modificateur)
    // {
    //     $this->modificateur = $modificateur;
    // }
    //
    // public function value(): int
    // {
    //     return $this->modificateur->apply($this);
    // }
    //
    // public function resolve(Manche $manche, Carte $carteAdverse)
    // {
    //     if($this->value() < $carteAdverse->value())
    //     {
    //         return $manche->setWinner($this->joueur());
    //     }
    //
    //     return $manche->setWinner($carteAdverse->joueur());
    // }
}
