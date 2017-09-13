<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;
use BraveRats\Domain\Manche;

class PredictibleScoreManche implements Manche
{
    private
        $score;

    public function __construct(int $score)
    {
        $this->score = $score;
    }

    public function resolve(Carte $carte1, Carte $carte2): ?Joueur
    {
    }

    public function score(): int
    {
        return $this->score;
    }

    public function nextMancheFromDraw(): \BraveRats\Domain\Manche
    {
    }

    public function nextMancheFromVictory(): \BraveRats\Domain\Manche
    {
    }
}
