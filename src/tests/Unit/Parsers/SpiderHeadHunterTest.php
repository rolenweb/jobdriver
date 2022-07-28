<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\Parser\LinkScraper;
use App\Parsers\Parser\Spider;
use App\Parsers\Parser\TextScraper;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\InvokePrivateMethod;

class SpiderHeadHunterTest extends TestCase
{
    use InvokePrivateMethod;

    public function testCanScrapeTitleItemListHeadHunter()
    {
        $textScraper = new TextScraper;
        $this->assertEquals(
            'Водитель курьер в Ozon Fresh на личном автомобиле',
            $textScraper(
                Storage::disk('tests_examples')->get('hh_item_list.html'),
                'span.serp-item__name a'
            )
        );
    }

    public function testCanScrapeLinkItemListHeadHunter()
    {
        $textScraper = new LinkScraper;
        $this->assertNotNull(
            $textScraper(
                Storage::disk('tests_examples')->get('hh_item_list.html'),
                'span.serp-item__name a',
                'https://hh.ru'
            )
        );
    }

    public function testSpiderCanScrapeList()
    {
        $spider = new Spider();
        $result = $this->invokeMethod($spider, 'scrapeProperty', [
            Storage::disk('tests_examples')->get('hh_item_list.html'),
            config('parsers.hh_ru.spider.properties')[0]
        ]);
        foreach ($result as $index => $items) {
            if ($index) {
                continue;
            }
            $this->assertEquals('title', $items[0]['name']);
            $this->assertEquals('Водитель курьер в Ozon Fresh на личном автомобиле', $items[0]['value']);
            $this->assertEquals('link', $items[1]['name']);
            $this->assertEquals('https://hh.ru/vacancy/68173569?from=vacancy_search_list&hhtmFrom=vacancy_search_list&query=%D0%B2%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8C', $items[1]['value']);

        }
    }
}
