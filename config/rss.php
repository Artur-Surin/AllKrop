<?php

return [
    'feeds' => [
        'news' => [
            ['name' => 'Суспільне Кропивницький', 'url' => 'https://suspilne.media/kropyvnytskiy/latest/', 'type' => 'html'],
            ['name' => 'Українська правда', 'url' => 'https://www.pravda.com.ua/rss/news/', 'type' => 'rss'],
            ['name' => 'Укрінформ', 'url' => 'https://www.ukrinform.net/rss', 'type' => 'rss'],
        ],
        'events' => [
            ['name' => 'Афіша Кропивницького', 'url' => 'https://afisha.kr.ua/rss', 'type' => 'rss'],
        ],
    ],
    'import_interval' => 3600,
    'default_image' => '/images/hero-city.png',
];
