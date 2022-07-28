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


    private function fakeHttpResponseHH(): Response
    {
        return Http::fake([
            'https://hh.ru/*' => Http::response(Storage::disk('tests_examples')->get('hh_list.html'), 200, [])
        ])->get('https://hh.ru/search/vacancy?area=113&search_field=name&text=%D0%B2%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8C&clusters=true&enable_snippets=true&ored_clusters=true&search_period=1&order_by=publication_time&hhtmFrom=vacancy_search_catalog');
    }
}
