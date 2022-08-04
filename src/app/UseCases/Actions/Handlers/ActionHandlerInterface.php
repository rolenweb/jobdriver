<?php

declare(strict_types=1);

namespace App\UseCases\Actions\Handlers;

use App\Enums\ActionHandlerEnum;
use Ramsey\Uuid\UuidInterface;

interface ActionHandlerInterface
{
    public function handle(UuidInterface $uuid, ActionHandlerEnum $handler): void;
}
