<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Dto\Parsers\Parser\SpiderDto;
use App\Parsers\Parser\LinkScraper;
use App\Parsers\Parser\ParserResponse;
use App\Parsers\Parser\Spider;
use App\Parsers\Parser\TextScraper;
use Illuminate\Http\Client\Response;
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

    public function testCanScrapeCompensationItemListHeadHunter()
    {
        $textScraper = new TextScraper;
        $this->assertNotNull(
            $textScraper(
                Storage::disk('tests_examples')->get('hh_item_list.html'),
                'span[data-qa=vacancy-serp__vacancy-compensation]'
            )
        );
    }

    public function testCanScrapeCompanyItemListHeadHunter()
    {
        $textScraper = new TextScraper;
        $this->assertEquals(
            'ООО Союз Регионы',
            $textScraper(
                Storage::disk('tests_examples')->get('hh_item_list.html'),
                'div.vacancy-serp-item__meta-info-company a',
            )
        );
    }

    public function testCanScrapeSnippetResponsibilityItemListHeadHunter()
    {
        $textScraper = new TextScraper;
        $this->assertNotNull(
            $textScraper(
                Storage::disk('tests_examples')->get('hh_item_list.html'),
                'div[data-qa=vacancy-serp__vacancy_snippet_responsibility]'
            )
        );
    }

    public function testSpiderCanScrapeCardListHeadHunter()
    {
        $spider = new Spider();
        $result = $this->invokeMethod($spider, 'scrapeProperty', [
            Storage::disk('tests_examples')->get('hh_list.html'),
            config('parsers.hh_ru.spider.properties')[0],
        ]);

        foreach ($result as $index => $items) {
            if ($index) {
                continue;
            }
            $this->assertEquals('title', $items[0]['name']);
            $this->assertEquals('Водитель-экспедитор категории Е', $items[0]['value']);
            $this->assertEquals('link', $items[1]['name']);
            $this->assertEquals('https://hhcdn.ru/click?b=288060&meta=TKXj2GOCJwdZ6SVIG-UxL5sl52sn8sVPyPkPvRGfi_BoULgdgzfR50PwTyQKXa9-Sk_oYFa-AYNXCxEjyz-F-XJRrXGhI6Wn0fCH7me__7ePEmQS1F0KO0h-wMvk4a1hu77qAvh1Dh2Kkz2UjBzH_g%3D%3D&c=25&place=35&clickType=link_to_vacancy', $items[1]['value']);
            $this->assertEquals('compensation', $items[2]['name']);
            $this->assertNotNull($items[2]['value']);
            $this->assertEquals('company', $items[3]['name']);
            $this->assertEquals('МАГНИТ, Розничная сеть', $items[3]['value']);
            $this->assertEquals('snippet_responsibility', $items[4]['name']);
            $this->assertNotNull($items[4]['value']);
        }
    }

    public function testSpiderCanScrapePagerHeadHunter()
    {
        $spider = new Spider();
        $result = $this->invokeMethod($spider, 'scrapeProperty', [
            Storage::disk('tests_examples')->get('hh_list.html'),
            config('parsers.hh_ru.spider.properties')[1],
        ]);

        foreach ($result as $index => $items) {
            foreach ($items as $item) {
                $this->assertContains('name', array_keys($item));
                $this->assertContains('value', array_keys($item));
            }
        }
    }

    public function testCanScrapeContentHeadHunter()
    {
        $spider = new Spider();
        $result = $this->invokeMethod($spider, 'scrapeContent', [
            Storage::disk('tests_examples')->get('hh_list.html'),
            config('parsers.hh_ru.spider.properties'),
        ]);

        $this->assertContains('card', array_keys($result));
        $this->assertContains('pager', array_keys($result));
    }

    public function testSpiderCanHandleRequestHeadHunter()
    {
        $spider = new Spider();

        $result = $spider->handle(
            new SpiderDto(
                'https://test_hh_list.ru/search/vacancy?area=......',
                config('parsers.hh_ru.spider.properties')
            )
        );

        $this->assertTrue($result instanceof ParserResponse);
        $this->assertTrue($result->getResponse() instanceof Response);
        $this->assertIsArray($result->getResult());
    }
}
