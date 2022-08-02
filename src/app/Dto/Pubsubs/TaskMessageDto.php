<?php

declare(strict_types=1);

namespace App\Dto\Pubsubs;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class TaskMessageDto
{
    private UuidInterface $taskId;

    private UuidInterface $actionId;

    private string $url;

    private array $properties;

    public function __construct(array $message)
    {
        Assert::uuid($message['taskId']);
        Assert::uuid($message['actionId']);
        Assert::isArray($message['task']['properties']);
        Assert::notEmpty($message['task']['url']);
        Assert::startsWith($message['task']['url'], 'http');

        $this->taskId = Uuid::fromString($message['taskId']);
        $this->actionId = Uuid::fromString($message['actionId']);
        $this->url = $message['task']['url'];
        $this->properties = $message['task']['properties'];
    }

    /**
     * @return UuidInterface
     */
    public function getTaskId(): UuidInterface
    {
        return $this->taskId;
    }

    /**
     * @return UuidInterface
     */
    public function getActionId(): UuidInterface
    {
        return $this->actionId;
    }

    /**
     * @return mixed|string
     */
    public function getUrl(): mixed
    {
        return $this->url;
    }

    /**
     * @return array|mixed
     */
    public function getProperties(): mixed
    {
        return $this->properties;
    }
}
