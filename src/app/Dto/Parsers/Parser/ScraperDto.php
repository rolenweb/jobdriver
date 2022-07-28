<?php

declare(strict_types=1);

namespace App\Dto\Parsers\Parser;

class ScraperDto
{
    private string $test;

    /**
     * @param string $test
     */
    public function __construct(string $test)
    {
        $this->test = $test;
    }

}
