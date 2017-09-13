<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Cartes;

use BraveRats\Domain\Cartes\AbstractCarte;
use BraveRats\Domain\Cartes\Modificateurs\BonusFromGeneral;
use BraveRats\Domain\Joueurs\Stub;
use PHPUnit\Framework\TestCase;

class MyCarte extends AbstractCarte
{
    public function value(): int
    {
        return 5;
    }
}

class AbstractCarteTest extends TestCase
{
    private
        $joueur1;

    public function setUp()
    {
        $this->joueur1 = new Stub();
    }

    public function testComputeValueWithModificateurs()
    {
        $carte = new MyCarte($this->joueur1);
        $this->assertSame($carte->value(), $carte->computeValueWithModificateurs());

        $this->joueur1->addBonusForNextManche(new BonusFromGeneral());
        $this->joueur1->initializeNewManche();

        $carte = new MyCarte($this->joueur1);

        $this->assertSame((new BonusFromGeneral())->apply($carte->value()), $carte->computeValueWithModificateurs());
    }
}
