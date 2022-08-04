<?php

declare(strict_types=1);

namespace App\UseCases\Actions\Handlers;

use App\Enums\ActionHandlerEnum;

interface ActionHandlerInterface
{
    public function handle(ActionHandlerEnum $handler): void;
}
