<?php

declare(strict_types=1);

namespace App\Pubsubs\Subscribers;

use App\Dto\Parsers\Parser\SpiderDto;
use App\Dto\Pubsubs\TaskMessageDto;
use App\Parsers\Parser\ParserResponse;
use App\Parsers\Parser\Spider;

class HeadHunterSpiderSubscriber
{
    public function __invoke($message)
    {
        $taskMessageDto = new TaskMessageDto($message);
        $scrapedData = $this->scrape($taskMessageDto->getUrl(), $taskMessageDto->getProperties());
    }

    /**
     * @param  string  $url
     * @param  array  $properties
     * @return ParserResponse
     */
    private function scrape(string $url, array $properties): ParserResponse
    {
        $dto = new SpiderDto($url, $properties);

        return (new Spider())->handle($dto);
    }

    private function analyze(ParserResponse $parserResponse)
    {
    }
}
