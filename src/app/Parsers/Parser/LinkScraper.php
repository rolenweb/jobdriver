<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

class LinkScraper
{
    /**
     * @param ...$params
     * @return Link
     */
    public function __invoke(...$params): string
    {
        return (new Crawler($params[0], $params[2]))->filter($params[1])->link()->getUri();
    }

}
