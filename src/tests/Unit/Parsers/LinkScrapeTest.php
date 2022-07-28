<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\Parser\LinkScraper;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LinkScrapeTest extends TestCase
{
    public function testCanScrapeLinkFromHtml()
    {
        $crawler = new LinkScraper;
        $this->assertEquals(
            'http://test.domain/vacancy/1?from=vacancy_search_list&hhtmFrom=vacancy_search_list',
            $crawler(
                Storage::disk('tests_examples')->get('simple.html'),
                'a.link',
                'http://test.domain'
            )
        );
    }
}
