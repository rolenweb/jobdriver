<?php

use App\Parsers\Parser\LinkScraper;
use App\Parsers\Parser\TextScraper;

return [
    'scrapers' => [
        'text' => TextScraper::class,
        'link' => LinkScraper::class
    ],
    'hh_ru' => [
        'spider' => [
            'url' => 'https://hh.ru/search/vacancy?area=113&search_field=name&text=%D0%B2%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8C&clusters=true&enable_snippets=true&ored_clusters=true&search_period=1&order_by=publication_time&hhtmFrom=vacancy_search_catalog',
            'properties' => [
                [
                    'css_selector' => 'div.serp-item',
                    'type' => 'html',
                    'name' => 'card',
                    'multiple' => true,
                    'valuable' => false,
                    'items' => [
                        [
                            'css_selector' => 'span.serp-item__name a',
                            'type' => 'text',
                            'name' => 'title',
                            'multiple' => false,
                            'valuable' => true,
                        ],
                        [
                            'css_selector' => 'span.serp-item__name a',
                            'uri' => 'https://hh.ru',
                            'type' => 'link',
                            'name' => 'link',
                            'multiple' => false,
                            'valuable' => true,
                        ]
                    ]

                ]
            ]
        ],
        'scraper' => [

        ]
    ]
];
