<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Collections\CarteCollection;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    private const
        NAME = 'moi';

    public function testConstruct()
    {
        $joueur = new Memory(self::NAME);

        $this->assertEquals(new CarteCollection($joueur), $joueur->cartes());
    }
}
