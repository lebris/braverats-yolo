<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Manche;
use BraveRats\Domain\Modificateur;
use BraveRats\Domain\Modificateurs\NullModificateur;

class Assassin extends AbstractCarte
{
    private const
        VALUE = 3;
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
