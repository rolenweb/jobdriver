<?php

declare(strict_types=1);

namespace Tests\Feature\Integration\UseCases\Actions;

use App\Dto\UseCases\Actions\CreateActionDto;
use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\Models\Actions\Action;
use App\UseCases\Actions\CreateActionUseCase;
use App\UseCases\UseCaseResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateActionUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateActionUseCase()
    {
        $dto = new CreateActionDto(
            'HH parser',
            ActionHandlerEnum::HeadHunterParser,
            ActionStatusEnum::wating
        );
        /**
         * @var UseCaseResponse $response
         * @var Action $action
         */
        $response = $this->app->make(CreateActionUseCase::class)->handle($dto);
        $action = $response->getData()->get('action');
        $this->assertNotNull($action->id);
        $this->assertEquals($dto->getName(), $action->name);
        $this->assertEquals($dto->getHandler(), $action->handler);
        $this->assertEquals($dto->getStatus(), $action->status);
    }
}
