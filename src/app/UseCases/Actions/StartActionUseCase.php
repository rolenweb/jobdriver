<?php

declare(strict_types=1);

namespace App\UseCases\Actions;


use App\Dto\Dto;
use App\Dto\UseCases\Actions\StartActionDto;
use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\Repositories\ActionRepository;
use App\UseCases\UseCaseInterface;
use App\UseCases\UseCaseResponse;
use Illuminate\Support\Facades\App;

class StartActionUseCase extends ActionUseCase implements UseCaseInterface
{
    private ActionRepository $actionRepository;

    /**
     * @param ActionRepository $actionRepository
     */
    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    /**
     * @param StartActionDto|Dto $dto
     * @return UseCaseResponse
     * @throws \Throwable
     */
    public function handle(StartActionDto|Dto $dto): UseCaseResponse
    {
        $action = $this->actionRepository->findById($dto->getUuid());
        $action->status = ActionStatusEnum::in_progress;
        $action = $this->actionRepository->save($action);
        $response = new UseCaseResponse([
            'action' => $action
        ]);

        $this->runHandler($action->handler, $action->status);

        return $response;
    }

    private function runHandler(ActionHandlerEnum $handler, ActionStatusEnum $status): void
    {
        App::make($this->findHandler($handler, $status))->handle($handler);
    }
}
