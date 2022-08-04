<?php

declare(strict_types=1);

namespace App\UseCases\Actions;

use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ActionUseCase
{
    /**
     * @param ActionHandlerEnum $handler
     * @param ActionStatusEnum $status
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function findHandler(ActionHandlerEnum $handler, ActionStatusEnum $status): string
    {
        return config('action_handlers')[$handler->value][$status->value];
    }
}
