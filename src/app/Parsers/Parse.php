<?php

declare(strict_types=1);

namespace App\Parsers;

class Parse
{
    public function __invoke()
    {
        foreach (config('parsers') as $key => $item) {
        }
        throw new \Exception('test');
    }
}
