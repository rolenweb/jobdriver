<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Actions;

use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\UseCases\Actions\ActionUseCase;
use App\UseCases\Actions\Handlers\ActionHandlerInterface;
use Tests\TestCase;
use Tests\Traits\InvokePrivateMethod;

class ActionUseCaseTest extends TestCase
{
    use InvokePrivateMethod;

    public function testCanFindHeadHunterHandlerWhenActionInProgress()
    {
        /**
         * @var ActionUseCase $useCase
         */
        $useCase = $this->app->make(ActionUseCase::class);

        $handler = $this->invokeMethod(
            $useCase,
            'findHandler',
            [
                ActionHandlerEnum::HeadHunterParser,
                ActionStatusEnum::in_progress
            ]
        );

        $this->assertEquals(
            'App\UseCases\Actions\Handlers\InProgressParsingWebHandler',
            $handler
        );

        $this->assertInstanceOf(
            ActionHandlerInterface::class,
            $this->app->make($handler)
        );
    }

    public function testCanFindHeadHunterHandlerWhenActionWaiting()
    {
        /**
         * @var ActionUseCase $useCase
         */
        $useCase = $this->app->make(ActionUseCase::class);

        $handler = $this->invokeMethod(
            $useCase,
            'findHandler',
            [
                ActionHandlerEnum::HeadHunterParser,
                ActionStatusEnum::wating
            ]
        );

        $this->assertEquals(
            'App\UseCases\Actions\Handlers\WaitingParsingWebHandler',
            $handler
        );

        $this->assertInstanceOf(
            ActionHandlerInterface::class,
            $this->app->make($handler)
        );
    }

    public function testCanFindHeadHunterHandlerWhenActionFinished()
    {
        /**
         * @var ActionUseCase $useCase
         */
        $useCase = $this->app->make(ActionUseCase::class);

        $handler = $this->invokeMethod(
            $useCase,
            'findHandler',
            [
                ActionHandlerEnum::HeadHunterParser,
                ActionStatusEnum::finished
            ]
        );

        $this->assertEquals(
            'App\UseCases\Actions\Handlers\FinishParsingWebHandler',
            $handler
        );

        $this->assertInstanceOf(
            ActionHandlerInterface::class,
            $this->app->make($handler)
        );
    }

    public function testCanFindHeadHunterHandlerWhenActionCanceled()
    {
        /**
         * @var ActionUseCase $useCase
         */
        $useCase = $this->app->make(ActionUseCase::class);

        $handler = $this->invokeMethod(
            $useCase,
            'findHandler',
            [
                ActionHandlerEnum::HeadHunterParser,
                ActionStatusEnum::canceled
            ]
        );

        $this->assertEquals(
            'App\UseCases\Actions\Handlers\CancelParsingWebHandler',
            $handler
        );

        $this->assertInstanceOf(
            ActionHandlerInterface::class,
            $this->app->make($handler)
        );
    }
}
