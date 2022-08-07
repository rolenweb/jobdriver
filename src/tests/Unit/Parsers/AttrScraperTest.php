<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\Parser\AttrScraper;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttrScraperTest extends TestCase
{
    public function testCanScrapeAttrOfElementFromHtml()
    {
        $scraper = new AttrScraper;
        $this->assertEquals('/vacancy/1?from=vacancy_search_list&hhtmFrom=vacancy_search_list', $scraper(Storage::disk('tests_examples')->get('simple.html'), 'a.link', 'href'));
    }
}
