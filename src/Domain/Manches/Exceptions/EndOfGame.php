<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches\Exceptions;
use BraveRats\Domain\Joueur;

class EndOfGame extends \RuntimeException
{
    private
        $result;

    public function __construct(Joueur $result)
    {
        $this->result = $result;
    }

    public function result(): Joueur
    {
        return $this->result;
    }
}
