<?php

declare(strict_types=1);

namespace App\UseCases\Actions\Handlers;

use App\Enums\ActionHandlerEnum;
use Ramsey\Uuid\UuidInterface;

class WaitingParsingWebHandler implements ActionHandlerInterface
{
    public function handle(UuidInterface $uuid, ActionHandlerEnum $handler): void
    {
        // TODO: Implement handle() method.
    }
}
