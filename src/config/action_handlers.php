<?php

use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\UseCases\Actions\Handlers\CancelParsingWebHandler;
use App\UseCases\Actions\Handlers\FinishParsingWebHandler;
use App\UseCases\Actions\Handlers\InProgressParsingWebHandler;
use App\UseCases\Actions\Handlers\WaitingParsingWebHandler;

return [
    ActionHandlerEnum::HeadHunterParser->value => [
        ActionStatusEnum::wating->value => WaitingParsingWebHandler::class,
        ActionStatusEnum::in_progress->value => InProgressParsingWebHandler::class,
        ActionStatusEnum::finished->value => FinishParsingWebHandler::class,
        ActionStatusEnum::canceled->value => CancelParsingWebHandler::class,
    ],
];
