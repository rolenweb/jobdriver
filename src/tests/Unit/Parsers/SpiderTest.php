<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Dto\Parsers\Parser\SpiderDto;
use App\Parsers\Parser\Spider;
use App\Parsers\Parser\TextScraper;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\InvokePrivateMethod;

class SpiderTest extends TestCase
{
    use InvokePrivateMethod;

    public function testSpiderCanScrapeList()
    {
        $spider = new Spider();
        $result = $this->invokeMethod($spider, 'scrapeProperty', [
            Storage::disk('tests_examples')->get('list.html'),
            [
                'css_selector' => 'div.item',
                'name' => 'card',
                'type' => 'html',
                'multiple' => true,
                'valuable' => false,
                'items' => [
                    [
                        'css_selector' => 'div.title',
                        'name' => 'title',
                        'type' => 'text',
                        'multiple' => false,
                        'valuable' => true,
                    ],
                    [
                        'css_selector' => 'a.link',
                        'uri' => 'http://test.domain',
                        'type' => 'link',
                        'name' => 'link',
                        'multiple' => false,
                        'valuable' => true,
                    ]
                ]

            ]
        ]);

        foreach ($result as $index => $items) {
            if ($index) {
                continue;
            }
            $this->assertEquals('title', $items[0]['name']);
            $this->assertEquals('Test title 1', $items[0]['value']);
            $this->assertEquals('link', $items[1]['name']);
            $this->assertEquals('http://test.domain/vacancy/1?from=vacancy_search_list&hhtmFrom=vacancy_search_list', $items[1]['value']);

        }
    }
}
