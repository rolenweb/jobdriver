<?php

declare(strict_types=1);

namespace Tests\Feature\Integration\Pubsubs;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class PubsubTest extends TestCase
{
    public function testCanPublishToRedisChannel()
    {
        Redis::publish('hh_spider', json_encode([
            'name' => 'Adam Wathan'
        ]));
        $this->assertTrue(true);
    }
}
