<?php

declare(strict_types = 1);

namespace BraveRats\Domain\Manches;

use BraveRats\Domain\Carte;
use BraveRats\Domain\Cartes\Stub;
use BraveRats\Domain\Cartes\Prince;
use BraveRats\Domain\Cartes\Espion;
use BraveRats\Domain\Cartes\General;
use BraveRats\Domain\Cartes\Magicien;
use BraveRats\Domain\Cartes\Assassin;
use BraveRats\Domain\Cartes\Musicien;
use BraveRats\Domain\Cartes\Princesse;
use BraveRats\Domain\Cartes\Ambassadeur;
use BraveRats\Domain\Joueurs\NullJoueur;
use BraveRats\Domain\Joueurs\Stub as StubJoueur;
use BraveRats\Domain\Cartes\Modificateurs\BonusFromGeneral;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    private const
        STRONG = 10,
        WEAK = 1;

    private
        $joueur1,
        $joueur2;

    public function setUp()
    {
        $this->joueur1 = new StubJoueur();
        $this->joueur2 = new StubJoueur();
    }

    public function testResolveJ1Wining()
    {
        $carte1 = new Stub($this->joueur1, self::STRONG);
        $carte2 = new Stub($this->joueur2, self::WEAK);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($this->joueur1, $result);
    }

    public function testResolveJ2Wining()
    {
        $carte1 = new Stub($this->joueur1, self::WEAK);
        $carte2 = new Stub($this->joueur2, self::STRONG);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($this->joueur2, $result);
    }

    public function testResolveDraw()
    {
        $carte1 = new Stub($this->joueur1, self::STRONG);
        $carte2 = new Stub($this->joueur2, self::STRONG);

        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame(null, $result);
    }

    public function testBonusForNextMancheUsingGeneral()
    {
        $j1 = new StubJoueur();
        $j2 = new StubJoueur();
        $carte1 = new General($j1);
        $carte2 = new Stub($j2, self::WEAK);

        (new Memory())->resolve($carte1, $carte2);

        $this->assertEquals([new BonusFromGeneral()], $j1->modificateursNextManche);
        $this->assertEquals([], $j2->modificateursNextManche);



        $j1 = new StubJoueur();
        $j2 = new StubJoueur();
        $carte1 = new Stub($j1, self::WEAK);
        $carte2 = new General($j2);

        (new Memory())->resolve($carte1, $carte2);

        $this->assertEquals([new BonusFromGeneral()], $j2->modificateursNextManche);
        $this->assertEquals([], $j1->modificateursNextManche);



        $j1 = new StubJoueur();
        $j2 = new StubJoueur();
        $carte1 = new General($j1);
        $carte2 = new General($j2);

        (new Memory())->resolve($carte1, $carte2);

        $this->assertEquals([new BonusFromGeneral()], $j1->modificateursNextManche);
        $this->assertEquals([new BonusFromGeneral()], $j2->modificateursNextManche);
    }

    public function testWithBonusFromPreviousManche()
    {
        $j1 = new StubJoueur();
        $j2 = new StubJoueur();
        $j1->addBonusForNextManche(new BonusFromGeneral());
        $j1->initializeNewManche();

        $carte1 = new Stub($j1, self::WEAK);
        $carte2 = new Stub($j2, self::WEAK);

        $result = (new Memory())->resolve($carte1, $carte2);

        $this->assertSame($j1, $result);




        $j1 = new StubJoueur();
        $j2 = new StubJoueur();
        $j2->addBonusForNextManche(new BonusFromGeneral());
        $j2->initializeNewManche();

        $carte1 = new Stub($j1, self::WEAK);
        $carte2 = new Stub($j2, self::WEAK);

        $result = (new Memory())->resolve($carte1, $carte2);

        $this->assertSame($j2, $result);
    }

    /**
     * @dataProvider providerTestResolvePrincessVsPrince
     * @expectedException BraveRats\Domain\Manches\Exceptions\EndOfGame
     */
    public function testResolvePrincessVsPrince($expected, Carte $carte1, Carte $carte2)
    {
        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($expected, $result);
    }

    public function providerTestResolvePrincessVsPrince()
    {
        $j1 = new NullJoueur();
        $j2 = new NullJoueur();

        return [

            'Prince vs Princesse' => [
                $j2,
                new Prince($j1),
                new Princesse($j2),
            ],


            'Princesse vs Prince' => [
                $j1,
                new Princesse($j1),
                new Prince($j2),
            ],

        ];
    }

    /**
     * @dataProvider providerTestResolve
     */
    public function testResolve($expected, Carte $carte1, Carte $carte2)
    {
        $manche = new Memory();
        $result = $manche->resolve($carte1, $carte2);

        $this->assertSame($expected, $result);
    }

    public function providerTestResolve()
    {
        $j1 = new NullJoueur();
        $j2 = new NullJoueur();

        return [
            'Musicien vs Prince' => [
                null,
                new Musicien($j1),
                new Prince($j2),
            ],
            'Musicien vs Musicien' => [
                null,
                new Musicien($j1),
                new Musicien($j2),
            ],
            'Musicien vs Princesse' => [
                null,
                new Musicien($j1),
                new Princesse($j2),
            ],
            'Musicien vs Espion' => [
                null,
                new Musicien($j1),
                new Espion($j2),
            ],
            'Musicien vs Assassin' => [
                null,
                new Musicien($j1),
                new Assassin($j2),
            ],
            'Musicien vs Ambassadeur' => [
                null,
                new Musicien($j1),
                new Ambassadeur($j2),
            ],
            'Musicien vs Magicien' => [
                $j2,
                new Musicien($j1),
                new Magicien($j2),
            ],
            'Musicien vs General' => [
                null,
                new Musicien($j1),
                new Prince($j2),
            ],


            'Prince vs Prince' => [
                null,
                new Prince($j1),
                new Prince($j2),
            ],

            'Prince vs General' => [
                $j1,
                new Prince($j1),
                new General($j2),
            ],

            'Prince vs Magicien' => [
                $j1,
                new Prince($j1),
                new Magicien($j2),
            ],

            'Prince vs Ambassadeur' => [
                $j1,
                new Prince($j1),
                new Ambassadeur($j2),
            ],

            'Prince vs Assassin' => [
                $j1,
                new Prince($j1),
                new Assassin($j2),
            ],

            'Prince vs Espion' => [
                $j1,
                new Prince($j1),
                new Espion($j2),
            ],

            'Prince vs Musicien' => [
                null,
                new Prince($j1),
                new Musicien($j2),
            ],


            'General vs Prince' => [
                $j2,
                new General($j1),
                new Prince($j2),
            ],

            'General vs General' => [
                null,
                new General($j1),
                new General($j2),
            ],

            'General vs Magicien' => [
                $j1,
                new General($j1),
                new Magicien($j2),
            ],

            'General vs Ambassadeur' => [
                $j1,
                new General($j1),
                new Ambassadeur($j2),
            ],

            'General vs Assassin' => [
                $j2,
                new General($j1),
                new Assassin($j2),
            ],

            'General vs Espion' => [
                $j1,
                new General($j1),
                new Espion($j2),
            ],

            'General vs Princesse' => [
                $j1,
                new General($j1),
                new Princesse($j2),
            ],

            'General vs Musicien' => [
                null,
                new General($j1),
                new Musicien($j2),
            ],





            'Magicien vs Prince' => [
                $j2,
                new Magicien($j1),
                new Prince($j2),
            ],

            'Magicien vs General' => [
                $j2,
                new Magicien($j1),
                new General($j2),
            ],

            'Magicien vs Magicien' => [
                null,
                new Magicien($j1),
                new Magicien($j2),
            ],

            'Magicien vs Ambassadeur' => [
                $j1,
                new Magicien($j1),
                new Ambassadeur($j2),
            ],

            'Magicien vs Assassin' => [
                $j1,
                new Magicien($j1),
                new Assassin($j2),
            ],

            'Magicien vs Espion' => [
                $j1,
                new Magicien($j1),
                new Espion($j2),
            ],

            'Magicien vs Princesse' => [
                $j1,
                new Magicien($j1),
                new Princesse($j2),
            ],

            'Magicien vs Musicien' => [
                $j1,
                new Magicien($j1),
                new Musicien($j2),
            ],





            'Ambassadeur vs Prince' => [
                $j2,
                new Ambassadeur($j1),
                new Prince($j2),
            ],

            'Ambassadeur vs General' => [
                $j2,
                new Ambassadeur($j1),
                new General($j2),
            ],

            'Ambassadeur vs Magicien' => [
                $j2,
                new Ambassadeur($j1),
                new Magicien($j2),
            ],

            'Ambassadeur vs Ambassadeur' => [
                null,
                new Ambassadeur($j1),
                new Ambassadeur($j2),
            ],

            'Ambassadeur vs Assassin' => [
                $j2,
                new Ambassadeur($j1),
                new Assassin($j2),
            ],

            'Ambassadeur vs Espion' => [
                $j1,
                new Ambassadeur($j1),
                new Espion($j2),
            ],

            'Ambassadeur vs Princesse' => [
                $j1,
                new Ambassadeur($j1),
                new Princesse($j2),
            ],

            'Ambassadeur vs Musicien' => [
                null,
                new Ambassadeur($j1),
                new Musicien($j2),
            ],





            'Assassin vs Prince' => [
                $j2,
                new Assassin($j1),
                new Prince($j2),
            ],

            'Assassin vs General' => [
                $j1,
                new Assassin($j1),
                new General($j2),
            ],

            'Assassin vs Magicien' => [
                $j2,
                new Assassin($j1),
                new Magicien($j2),
            ],

            'Assassin vs Ambassadeur' => [
                $j1,
                new Assassin($j1),
                new Ambassadeur($j2),
            ],

            'Assassin vs Assassin' => [
                null,
                new Assassin($j1),
                new Assassin($j2),
            ],

            'Assassin vs Espion' => [
                $j2,
                new Assassin($j1),
                new Espion($j2),
            ],

            'Assassin vs Princesse' => [
                $j2,
                new Assassin($j1),
                new Princesse($j2),
            ],

            'Assassin vs Musicien' => [
                null,
                new Assassin($j1),
                new Musicien($j2),
            ],




            'Espion vs Prince' => [
                $j2,
                new Espion($j1),
                new Prince($j2),
            ],

            'Espion vs General' => [
                $j2,
                new Espion($j1),
                new General($j2),
            ],

            'Espion vs Magicien' => [
                $j2,
                new Espion($j1),
                new Magicien($j2),
            ],

            'Espion vs Ambassadeur' => [
                $j2,
                new Espion($j1),
                new Ambassadeur($j2),
            ],

            'Espion vs Assassin' => [
                $j1,
                new Espion($j1),
                new Assassin($j2),
            ],

            'Espion vs Espion' => [
                null,
                new Espion($j1),
                new Espion($j2),
            ],

            'Espion vs Princesse' => [
                $j1,
                new Espion($j1),
                new Princesse($j2),
            ],

            'Espion vs Musicien' => [
                null,
                new Espion($j1),
                new Musicien($j2),
            ],




            'Princesse vs General' => [
                $j2,
                new Princesse($j1),
                new General($j2),
            ],

            'Princesse vs Magicien' => [
                $j2,
                new Princesse($j1),
                new Magicien($j2),
            ],

            'Princesse vs Ambassadeur' => [
                $j2,
                new Princesse($j1),
                new Ambassadeur($j2),
            ],

            'Princesse vs Assassin' => [
                $j1,
                new Princesse($j1),
                new Assassin($j2),
            ],

            'Princesse vs Espion' => [
                $j2,
                new Princesse($j1),
                new Espion($j2),
            ],

            'Princesse vs Princesse' => [
                null,
                new Princesse($j1),
                new Princesse($j2),
            ],

            'Princesse vs Musicien' => [
                null,
                new Princesse($j1),
                new Musicien($j2),
            ],

        ];
    }
}
