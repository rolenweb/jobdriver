<?php

declare(strict_types=1);

namespace App\UseCases\Actions;

use App\Dto\Dto;
use App\Dto\UseCases\Actions\CreateActionDto;
use App\Models\Actions\Action;
use App\Repositories\ActionRepository;
use App\UseCases\UseCaseInterface;
use App\UseCases\UseCaseResponse;
use Throwable;

class CreateActionUseCase implements UseCaseInterface
{
    private ActionRepository $actionRepository;

    /**
     * @param  ActionRepository  $actionRepository
     */
    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    /**
     * @param  CreateActionDto|Dto  $dto
     * @return UseCaseResponse
     *
     * @throws Throwable
     */
    public function handle(CreateActionDto|Dto $dto): UseCaseResponse
    {
        $action = Action::create();
        $action->name = $dto->getName();
        $action->handler = $dto->getHandler();
        $action->status = $dto->getStatus();
        $action = $this->actionRepository->save($action);

        return new UseCaseResponse([
            'action' => $action,
        ]);
    }
}
