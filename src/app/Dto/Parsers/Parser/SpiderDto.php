<?php

declare(strict_types=1);

namespace App\Dto\Parsers\Parser;

class SpiderDto
{
    private string $url;

    private array $properties;

    /**
     * @param string $url
     * @param array $properties
     */
    public function __construct(string $url, array $properties)
    {
        $this->url = $url;
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
