<?php

declare(strict_types = 1);

namespace Naoned\Kenao\Domain\Collections;

use PHPUnit\Framework\TestCase;
use BraveRats\Domain\Collections\JoueurCollection;
use BraveRats\Domain\Joueurs\NullJoueur;

class JoueurCollectionTest extends TestCase
{
    public function testAdd()
    {
        $collection = new JoueurCollection(new NullJoueur(), new NullJoueur());

        foreach($collection as $joueur)
        {
            $this->assertTrue($joueur instanceof NullJoueur);
        }

        $this->assertCount(2, $collection);
    }
}
