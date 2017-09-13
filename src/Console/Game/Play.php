<?php

namespace BraveRats\Console\Game;

use BraveRats\Domain\Collections\JoueurCollection;
use BraveRats\Domain\Parties\Memory as Partie;
use BraveRats\Domain\Joueurs\Memory as Joueur;
use BraveRats\Infrastructure\IO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Play extends Command
{
    protected function configure()
    {
        $this->setName('game:play')
             ->setDescription('Run the game');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Game is running.');

        $joueurs = new JoueurCollection(
            new Joueur('1'),
            new Joueur('2')
        );

        $io = new IO($output, $input);

        $game = new Partie(
            $io,
            $joueurs
        );

        $game->play();
    }
}
