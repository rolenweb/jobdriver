<?php

declare(strict_types=1);

namespace App\Dto\UseCases\Actions;

use App\Dto\Dto;
use Ramsey\Uuid\UuidInterface;

class StartActionDto implements Dto
{
    private UuidInterface $uuid;

    /**
     * @param  UuidInterface  $uuid
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
