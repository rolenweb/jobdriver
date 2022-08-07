<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\Parser\TextScraper;
use Illuminate\Support\Facades\Storage;

class TextScraperTest extends \Tests\TestCase
{
    public function testCanScrapeElementFromHtmlAsText()
    {
        $textScraper = new TextScraper;
        $this->assertEquals('test', $textScraper(Storage::disk('tests_examples')->get('simple.html'), 'div.test'));
        $this->assertEquals('test', $textScraper(Storage::disk('tests_examples')->get('simple.html'), 'div#test'));
    }
}
