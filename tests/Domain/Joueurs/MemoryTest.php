<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Joueurs;

use BraveRats\Domain\Modificateur;
use BraveRats\Domain\Collections\CarteCollection;
use BraveRats\Domain\Manches\PredictibleScoreManche;
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

    public function testScore()
    {
        $joueur = new Memory(self::NAME);
        $this->assertSame(0, $joueur->score());

        $joueur->gagne(new PredictibleScoreManche(1));
        $this->assertSame(1, $joueur->score());

        $joueur->gagne(new PredictibleScoreManche(1));
        $this->assertSame(2, $joueur->score());

        $joueur->gagne(new PredictibleScoreManche(10));
        $this->assertSame(12, $joueur->score());
    }
}
