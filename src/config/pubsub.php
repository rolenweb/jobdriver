<?php

use App\Pubsubs\Subscribers\HeadHunterSpiderSubscriber;

return [
    'channels' => [
        'hh_spider' => HeadHunterSpiderSubscriber::class
    ]
];
