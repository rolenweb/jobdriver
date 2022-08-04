<?php

declare(strict_types=1);

namespace App\Enums;

enum ActionStatusEnum: string
{
    case wating = 'waiting';
    case in_progress  = 'in_progress';
    case finished = 'finished';
    case canceled = 'canceled';
}
