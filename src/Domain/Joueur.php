<?php

declare(strict_types = 1);

namespace BraveRats\Domain;

use BraveRats\Domain\Cartes\Modificateur;
use BraveRats\Domain\Collections\CarteCollection;

interface Joueur
{
    public function gagne(Manche $manche): void;

    public function cartes(): CarteCollection;

    public function score(): int;

    public function name(): string;

    public function addBonusForNextManche(Modificateur $modificateur): void;
}
