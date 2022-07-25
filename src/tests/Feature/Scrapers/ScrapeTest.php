<?php

declare(strict_types=1);

namespace Tests\Feature\Scrapers;

use App\Scrapers\Scrape;
use Tests\TestCase;

class ScrapeTest extends TestCase
{
    public function testCanRunScraping()
    {
        $scrape = new Scrape;
        $scrape();
        $this->assertTrue(true);
    }
}
