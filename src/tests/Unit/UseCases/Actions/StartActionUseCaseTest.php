<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Actions;

use App\Dto\UseCases\Actions\StartActionDto;
use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\Models\Actions\Action;
use App\Repositories\ActionRepository;
use App\UseCases\Actions\Handlers\ActionHandlerInterface;
use App\UseCases\Actions\Handlers\InProgressParsingWebHandler;
use App\UseCases\Actions\StartActionUseCase;
use App\UseCases\UseCaseResponse;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\TestCase;

class StartActionUseCaseTest extends TestCase
{
    public function testCanStartActionUseCase()
    {
        $dto = new StartActionDto(Str::uuid());
        $action = Action::create();
        $action->id = $dto->getUuid();
        $action->name = 'name';
        $action->handler = ActionHandlerEnum::HeadHunterParser;
        $action->status = ActionStatusEnum::wating;

        $this->mock(ActionRepository::class, function (MockInterface $mock) use ($action, $dto){
            $mock
                ->shouldReceive('findById')
                ->with($dto->getUuid())
                ->once()
                ->andReturn($action);

            $mock
                ->shouldReceive('save')
                ->once()
                ->andReturn($action);
        });

        $this->mock(InProgressParsingWebHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('handle')->with(ActionHandlerEnum::HeadHunterParser)->once();
        });

        /**
         * @var UseCaseResponse $response
         */
        $response = $this->app->make(StartActionUseCase::class)->handle($dto);
        $this->assertEquals(
            ActionStatusEnum::in_progress,
            $response->getData()->get('action')->status
        );
    }
}
