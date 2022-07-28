<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use Symfony\Component\DomCrawler\Crawler;

class AttrScraper
{
    /**
     * @param mixed ...$params
     * @return string|null
     */
    public function __invoke(...$params)
    {
        return (new Crawler($params[0]))->filter($params[1])->attr($params[2]);
    }

}
