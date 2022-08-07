<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config('pubsub.channels') as $channel => $subscriberClass) {
            Redis::subscribe([$channel], function ($message) use ($subscriberClass) {
                $subscriber = new $subscriberClass;
                $subscriber($message);
            });
        }
    }
}
