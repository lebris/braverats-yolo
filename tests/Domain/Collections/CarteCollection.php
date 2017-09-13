<?php

declare(strict_types  = 1);

namespace Naoned\Kenao\Domain\Collections;

use BraveRats\Domain\Cartes\Espion;
use BraveRats\Domain\Cartes\General;
use BraveRats\Domain\Cartes\Musicien;
use BraveRats\Domain\Cartes\Magicien;
use BraveRats\Domain\Cartes\Assassin;
use BraveRats\Domain\Cartes\Prince;
use BraveRats\Domain\Cartes\Princesse;
use BraveRats\Domain\Cartes\Ambassadeur;
use BraveRats\Domain\Collections\CarteCollection;
use BraveRats\Domain\Carte;
use BraveRats\Domain\Joueurs\NullJoueur;
use PHPUnit\Framework\TestCase;

class CarteCollectionTest extends TestCase
{
    public function testConstruct()
    {
        $collection = new CarteCollection(new NullJoueur());

        foreach($collection as $carte)
        {
            $this->assertTrue($carte instanceof Carte);
        }

        $this->assertCount(8, $collection);
        $this->assertExpectedCarte($collection);
    }

    private function assertExpectedCarte(CarteCollection $collection)
    {
        $curentCartes = [];
        foreach($collection as $carte)
        {
            $curentCartes[] = get_class($carte);
        }

        $this->assertSame(
            [
                Ambassadeur::class,
                Assassin::class,
                Espion::class,
                General::class,
                Magicien::class,
                Musicien::class,
                Prince::class,
                Princesse::class,
            ],
            $curentCartes
        );
    }
}
