<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use Symfony\Component\DomCrawler\Crawler;

class TextScraper
{
    /**
     * @param mixed ...$params
     * @return string
     */
    public function __invoke(...$params): string
    {
        return (new Crawler($params[0]))->filter($params[1])->text();
    }

}
