<?php

declare(strict_types = 1);

namespace BraveRats\Infrastructure\IOs;

use BraveRats\Domain\Cartes\Espion;
use BraveRats\Domain\Cartes\Prince;
use BraveRats\Domain\Cartes\General;
use BraveRats\Domain\Cartes\Magicien;
use BraveRats\Domain\Cartes\Musicien;
use BraveRats\Domain\Cartes\Assassin;
use BraveRats\Domain\Cartes\Princesse;
use BraveRats\Domain\Cartes\Ambassadeur;
use BraveRats\Domain\Collections\CarteCollection;
use BraveRats\Infrastructure\IO;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class Symfony implements IO
{
    public
        $input,
        $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->values = array(
            Assassin::VALUE => 'Assassin',
            Ambassadeur::VALUE => 'Ambassadeur',
            Espion::VALUE => 'Espion',
            General::VALUE => 'General',
            Magicien::VALUE => 'Magicien',
            Musicien::VALUE => 'Musicien',
            Prince::VALUE => 'Prince',
            Princesse::VALUE => 'Princesse',
        );

        ksort($this->values);
    }

    public function getCarteJouee(\BraveRats\Domain\Joueur $joueur)
    {
        $helper = new QuestionHelper();

        $question = new ChoiceQuestion(
            sprintf('Quelle carte joue %s ?', $joueur->name()),
            $this->formatCartesForDisplay($joueur->cartes()),
            0
        );
        $question->setErrorMessage('Color %s is invalid.');

        return $helper->ask($this->input, $this->output, $question);
    }

    public function output(string $message): void
    {
        $this->output->writeln($message);
    }

    private function formatCartesForDisplay(CarteCollection $cartes)
    {
        $display = [];
        foreach($cartes as $carte)
        {
            $display[$carte->value()] = str_replace('BraveRats\Domain\Cartes\\', '', get_class($carte));
        }

        ksort($display);

        return $display;
    }
}
