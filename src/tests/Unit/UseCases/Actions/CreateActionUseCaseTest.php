<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Actions;

use App\Dto\UseCases\Actions\CreateActionDto;
use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\Models\Actions\Action;
use App\Repositories\ActionRepository;
use App\UseCases\Actions\CreateActionUseCase;
use App\UseCases\UseCaseResponse;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateActionUseCaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCanCreateActionUseCase()
    {
        $dto = new CreateActionDto(
            'HH parser',
            ActionHandlerEnum::HeadHunterParser,
            ActionStatusEnum::wating
        );
        $mockedAction = Action::create();
        $mockedAction->name = $dto->getName();
        $mockedAction->handler = $dto->getHandler();
        $mockedAction->status = $dto->getStatus();

        $this->mock(ActionRepository::class, function (MockInterface $mock) use ($mockedAction) {
            $mock
                ->shouldReceive('save')
                ->once()
                ->andReturn($mockedAction);
        });

        $response = $this->app->make(CreateActionUseCase::class)->handle($dto);
        $this->assertInstanceOf(UseCaseResponse::class, $response);
        $this->assertNotNull($response->getData()->get('action'));
        $this->assertInstanceOf(Action::class, $response->getData()->get('action'));
    }
}
