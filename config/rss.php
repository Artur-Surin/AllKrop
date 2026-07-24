<?php

return [
    'feeds' => [
        'news' => [
            ['name' => 'Суспільне Кропивницький', 'url' => 'https://suspilne.media/kr/rss'],
            ['name' => 'Вечірній Кропивницький', 'url' => 'https://vechirniy.kr.ua/rss'],
            ['name' => 'Громадське ТБ Кіровоградщини', 'url' => 'https://kr.gromadske.tv/rss'],
        ],
        'events' => [
            ['name' => 'Афіша Кропивницького', 'url' => 'https://afisha.kr.ua/rss'],
        ],
    ],
    'import_interval' => 3600,
    'default_image' => '/images/hero-city.png',
];
