<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use App\Dto\Parsers\Parser\SpiderDto;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class Spider
{
    /**
     * @param SpiderDto $spiderDto
     * @return ParserResponse
     */
    public function handle(SpiderDto $spiderDto): ParserResponse
    {
        $pageResponse = $this->scrapePage($spiderDto->getUrl());
        $content = $this->scrapeContent($pageResponse->body(), $spiderDto->getProperties());

        return new ParserResponse($pageResponse, $content);
    }

    /**
     * @param string $url
     * @return Response
     */
    private function scrapePage(string $url): Response
    {
        return Http::fake([
            'https://test_hh_list.ru/*' => Http::response(Storage::disk('tests_examples')->get('hh_list.html'), 200, [])
        ])->get($url);
    }

    /**
     * @param string $body
     * @param array $properties
     * @return array
     */
    private function scrapeContent(string $body, array $properties)
    {
        $content = [];
        foreach ($properties as $property) {
            $content[$property['name']] = $this->scrapeProperty($body, $property);
        }

        return $content;
    }

    /**
     * @param string $body
     * @param array $property
     * @return array
     */
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

        try {
            $value = $scraper(...$params);
        } catch (\Throwable $throwable) {
            $value = null;
            Log::error($throwable->getMessage(), $property);
        }
        return [
            'name' => $property['name'],
            'value' => $value
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
