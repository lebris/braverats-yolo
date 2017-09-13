<?php

declare(strict_types = 1);

namespace BraveRats\Domain;

interface Manche
{
    public function resolve(Carte $carte1, Carte $carte2): ?Joueur;

    public function score(): int;

    public function nextMancheFromDraw(): Manche;

    public function nextMancheFromVictory(): Manche;
}
