<?php

return [
    'feeds' => [
        'news' => [
            ['name' => 'Суспільне Новини', 'url' => 'https://suspilne.media/feed'],
            ['name' => 'Українська правда', 'url' => 'https://www.pravda.com.ua/rss/news/'],
            ['name' => 'Укрінформ', 'url' => 'https://www.ukrinform.net/rss'],
        ],
        'events' => [
            ['name' => 'Афіша Кропивницького', 'url' => 'https://afisha.kr.ua/rss'],
        ],
    ],
    'import_interval' => 3600,
    'default_image' => '/images/hero-city.png',
];
