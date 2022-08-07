<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Pubsubs;

use App\Dto\Pubsubs\TaskMessageDto;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class TaskMessageDtoTest extends TestCase
{
    use WithFaker;

    private array $message;

    protected function setUp(): void
    {
        parent::setUp();
        $this->message = [
            'taskId' => Str::uuid()->toString(),
            'actionId' => Str::uuid()->toString(),
            'task' => [
                'url' => 'http://test.ru',
                'properties' => [

                ],
            ],
        ];
    }

    public function testCanCreateTaskMessageDtoFromMessage()
    {
        new TaskMessageDto($this->message);
        $this->assertTrue(true);
    }

    public function testThrowInvalidArgumentExceptionIfTaskIdIsNotUuid()
    {
        $this->expectException(InvalidArgumentException::class);
        $message = $this->message;
        $message['taskId'] = $this->faker->text(10);
        new TaskMessageDto($message);
    }

    public function testThrowInvalidArgumentExceptionIfActionIdIsNotUuid()
    {
        $this->expectException(InvalidArgumentException::class);
        $message = $this->message;
        $message['actionId'] = $this->faker->text(10);
        new TaskMessageDto($message);
    }
}
