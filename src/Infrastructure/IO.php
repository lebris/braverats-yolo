<?php

declare(strict_types = 1);

namespace BraveRats\Infrastructure;

use BraveRats\Domain\Joueur;

interface IO
{
    public function getCarteJouee(Joueur $joueur);

    public function output(string $message): void;
}
