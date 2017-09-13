<?php

declare(strict_types = 1);

namespace BraveRats\Infrastructure\IOs;

use BraveRats\Domain\Joueur;
use BraveRats\Infrastructure\IO;

class PredictibleIO implements IO
{
    private
        $predictions;

    public function __construct(array $predictions)
    {
        $this->predictions = $predictions;
    }

    public function getCarteJouee(Joueur $joueur)
    {
        if(! array_key_exists($joueur->name(), $this->predictions))
        {
            throw new \LogicException(sprintf('No predictions for joueur %s', $joueur->name()));
        }

        return array_shift($this->predictions[$joueur->name()]);
    }

    public function output(string $message): void
    {

    }
}
