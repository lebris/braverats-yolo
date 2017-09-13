<?php

declare(strict_types = 1);

namespace BraveRats\Infrastructure\IOs;

use BraveRats\Infrastructure\IO;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Symfony implements IO
{
    public
        $input,
        $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }
}
