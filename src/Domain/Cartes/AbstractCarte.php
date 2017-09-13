<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueur;

abstract class AbstractCarte implements Carte
{
    protected
        $joueur,
        $modificateursCurrentManche;

    public function __construct(Joueur $joueur)
    {
        $this->joueur = $joueur;
    }

    public function joueur(): Joueur
    {
        return $this->joueur;
    }

    public function computeValueWithModificateurs()
    {
        $value = $this->value();

        foreach($this->joueur->modificateursCurrentManche() as $modificateur)
        {
            $value = $modificateur->apply($value);
        }

        return $value;
    }

    public function is(int $value): bool
    {
        return $this->value() === $value;
    }

    abstract public function value(): int;
}
