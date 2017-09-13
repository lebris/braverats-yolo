<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches;

use BraveRats\Domain\Cartes\Stub;
use BraveRats\Domain\Joueurs\NullJoueur;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    private const
        STRONG = 10,
        WEAK = 1;

    public function testResolveJ1Wining()
    {
        $joueur1 = new NullJoueur();
        $joueur2 = new NullJoueur();

        $carte1 = new Stub($joueur1, self::STRONG);
        $carte2 = new Stub($joueur2, self::WEAK);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($joueur1, $result);
    }

    public function testResolveJ2Wining()
    {
        $joueur1 = new NullJoueur();
        $joueur2 = new NullJoueur();

        $carte1 = new Stub($joueur1, self::WEAK);
        $carte2 = new Stub($joueur2, self::STRONG);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($joueur2, $result);
    }

    public function testResolveDraw()
    {
        $joueur1 = new NullJoueur();
        $joueur2 = new NullJoueur();

        $carte1 = new Stub($joueur1, self::STRONG);
        $carte2 = new Stub($joueur2, self::STRONG);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame(null, $result);
    }
}
