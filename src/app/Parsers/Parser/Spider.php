<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use App\Dto\Parsers\Parser\SpiderDto;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class Spider
{

    public function handle(SpiderDto $spiderDto)
    {
        $pageResponse = $this->scrapePage($spiderDto->getUrl());
        $content = $this->scrapeContent($pageResponse->body(), $spiderDto->getProperties());
    }

    private function scrapePage(string $url): Response
    {
        return Http::get($url);
    }

    private function scrapeContent(string $body, array $properties)
    {
        foreach ($properties as $property) {

        }
    }

    private function scrapeProperty(string $body, array $property): array
    {
        if ($property['multiple']) {
            return (new Crawler($body))->filter($property['css_selector'])->each(function ($node) use ($property){
                $results = [];
                foreach ($property['items'] as $item) {
                    $results[] = $this->scrapeProperty($node->html(), $item);
                }
                return $results;
            });
        }

        $classNameScraper = $this->getClassNameScraper($property['type']);
        $scraper = new $classNameScraper;
        $params = array_merge([$body], array_values($property));

        return [
            'name' => $property['name'],
            'value' => $scraper(...$params)
        ];
    }

    /**
     * @param string $type
     * @return string
     */
    private function getClassNameScraper(string $type): string
    {
        return config('parsers.scrapers')[$type];
    }
}
