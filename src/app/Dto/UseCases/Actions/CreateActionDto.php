<?php

declare(strict_types=1);

namespace App\Dto\UseCases\Actions;

use App\Dto\Dto;
use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;

class CreateActionDto implements Dto
{
    private string $name;

    private ActionHandlerEnum $handler;

    private ActionStatusEnum $status;

    /**
     * @param string $name
     * @param ActionHandlerEnum $handler
     * @param ActionStatusEnum $status
     */
    public function __construct(string $name, ActionHandlerEnum $handler, ActionStatusEnum $status)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ActionHandlerEnum
     */
    public function getHandler(): ActionHandlerEnum
    {
        return $this->handler;
    }

    /**
     * @return ActionStatusEnum
     */
    public function getStatus(): ActionStatusEnum
    {
        return $this->status;
    }
}
