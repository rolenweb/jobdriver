<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Dto\Dto;

interface UseCaseInterface
{
    public function handle(Dto $dto): UseCaseResponse;
}
