<?php

declare(strict_types = 1);

namespace __ONYX_Namespace\__KENAO_BoundedContext\Application\Commands\__ONYX_CommandNamespace;

use Onyx\Services\CQS\Command;
use Onyx\Services\CQS\CommandHandler;

class Handler implements CommandHandler
{
    public function accept(Command $command): bool
    {
        return $command instanceof __ONYX_CommandNameCommand;
    }

    public function handle(Command $command): void
    {
    }
}
