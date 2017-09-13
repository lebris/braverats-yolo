<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches\Exceptions;
use BraveRats\Domain\Joueur;

class Draw extends Solved
{
    public function __construct()
    {
        parent::__construct(null);
    }
}
