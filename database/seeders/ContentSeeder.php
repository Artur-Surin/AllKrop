<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Landmark;
use App\Models\News;
use App\Models\Place;
use App\Models\PlaceCategory;
use App\Models\ServiceGroup;
use App\Models\ServiceItem;
use App\Models\TransportRoute;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedNews();
        $this->seedEvents();
        $this->seedPlaceCategories();
        $this->seedPlaces();
        $this->seedLandmarks();
        $this->seedTransportRoutes();
        $this->seedServiceGroups();
    }

    private function seedNews(): void
    {
        $items = [
            [
                'slug' => 'onovlena-pishohidna-zona',
                'tag' => 'Місто',
                'title' => 'У центрі Кропивницького відкрили оновлену пішохідну зону',
                'excerpt' => 'Реконструйована вулиця отримала нове освітлення, лавки та зелені насадження — простір для прогулянок і подій.',
                'date' => '24 липня',
                'read_time' => '3 хв',
                'image' => '/images/hero-city.png',
                'body' => [
                    'Після кількох місяців робіт у самому серці міста офіційно відкрили оновлену пішохідну зону. Простір спроєктували так, щоб він був зручним для родин з дітьми, людей з інвалідністю та велосипедистів.',
                    'Тут з\'явилося енергоефективне освітлення, десятки нових лавок, урни для роздільного збору відходів і понад сотня молодих дерев та кущів. Уздовж вулиці облаштували майданчики, де вихідними проходитимуть ярмарки та вуличні концерти.',
                    'Міська рада повідомляє, що це лише перший етап оновлення центральної частини — наступного року роботи продовжать на прилеглих вулицях.',
                ],
            ],
            [
                'slug' => 'novi-marshruty-elektrobusiv',
                'tag' => 'Транспорт',
                'title' => 'Запускають нові маршрути електробусів між районами',
                'excerpt' => 'Мешканці зможуть швидше діставатися з околиць до центру завдяки оновленому громадському транспорту.',
                'date' => '22 липня',
                'read_time' => '2 хв',
                'image' => '/images/landmark-park.png',
                'body' => [
                    'Місто розширює мережу електротранспорту: на маршрути виходять нові електробуси, які з\'єднають віддалені житлові масиви з центром та залізничним вокзалом.',
                    'Нові транспортні засоби мають низьку підлогу, обладнані місцями для маломобільних пасажирів, USB-зарядками та інформаційними табло.',
                ],
            ],
            [
                'slug' => 'muzej-prosto-neba',
                'tag' => 'Культура',
                'title' => 'Музей просто неба поповнився новою колекцією',
                'excerpt' => 'Експозицію присвячено ремеслам краю — від гончарства до ткацтва. Вхід для школярів безкоштовний.',
                'date' => '20 липня',
                'read_time' => '4 хв',
                'image' => '/images/place-gallery.png',
                'body' => [
                    'Музей просто неба відкрив нову постійну експозицію, присвячену традиційним ремеслам Центральної України.',
                    'Для гостей проводитимуть майстер-класи, де можна власноруч спробувати сформувати глиняний глечик чи виткати смужку рушника.',
                ],
            ],
            [
                'slug' => 'festyval-upersonskoi-kuhni',
                'tag' => 'Події',
                'title' => 'Місто готується до великого гастрономічного фестивалю',
                'excerpt' => 'Наприкінці серпня центральні вулиці перетворяться на майданчик локальної кухні та виноробства.',
                'date' => '18 липня',
                'read_time' => '3 хв',
                'image' => '/images/event-market.png',
                'body' => [
                    'Наприкінці серпня в Кропивницькому відбудеться масштабний гастрономічний фестиваль.',
                    'Гості зможуть скуштувати страви регіональної кухні, відвідати дегустації та кулінарні шоу від відомих шефів.',
                ],
            ],
            [
                'slug' => 'sportyvnyj-maidanchyk',
                'tag' => 'Спорт',
                'title' => 'У парку відкрили сучасний спортивний майданчик',
                'excerpt' => 'Безкоштовний простір для воркауту, скейтингу та ігрових видів спорту.',
                'date' => '15 липня',
                'read_time' => '2 хв',
                'image' => '/images/landmark-park.png',
                'body' => [
                    'У міському парку завершили будівництво сучасного спортивного майданчика.',
                    'Покриття виконане з ударопоглинальних матеріалів, а територія обладнана освітленням для вечірніх тренувань.',
                ],
            ],
            [
                'slug' => 'volonterskyj-hab',
                'tag' => 'Спільнота',
                'title' => 'У місті запрацював новий волонтерський хаб',
                'excerpt' => 'Простір об\'єднує ініціативи мешканців — від допомоги військовим до екологічних проєктів.',
                'date' => '12 липня',
                'read_time' => '3 хв',
                'image' => '/images/place-cafe.png',
                'body' => [
                    'Новий волонтерський хаб став центром об\'єднання громадських ініціатив міста.',
                    'Простір відкритий для всіх, хто хоче долучитися до волонтерства.',
                ],
            ],
        ];

        foreach ($items as $item) {
            News::create($item);
        }
    }

    private function seedEvents(): void
    {
        $items = [
            [
                'slug' => 'litnij-muzychnyj-vechir',
                'image' => '/images/event-concert.png',
                'title' => 'Літній музичний вечір на площі',
                'category' => 'Концерт',
                'date' => '27 ЛИП',
                'time' => '19:00',
                'place' => 'Центральна площа',
                'price' => 'Безкоштовно',
                'description' => [
                    'Проведіть теплий літній вечір під живу музику просто неба. На головній сцені міста виступлять місцеві гурти та запрошені виконавці.',
                    'На гостей чекає зона фудкорту з локальними стравами та напоями, а також простір для відпочинку родинами.',
                ],
            ],
            [
                'slug' => 'yarmarok-remesel',
                'image' => '/images/event-market.png',
                'title' => 'Ярмарок ремесел та локальної їжі',
                'category' => 'Ярмарок',
                'date' => '02 СЕР',
                'time' => '10:00',
                'place' => 'Ковалівський парк',
                'price' => 'Вхід вільний',
                'description' => [
                    'Великий ярмарок збере майстрів з усього регіону: кераміка, вишивка, вироби з дерева та шкіри.',
                    'Упродовж дня — майстер-класи, дитячі активності та музичний супровід.',
                ],
            ],
            [
                'slug' => 'premiera-u-teatri',
                'image' => '/images/landmark-theatre.png',
                'title' => 'Прем\'єра у драматичному театрі',
                'category' => 'Театр',
                'date' => '09 СЕР',
                'time' => '18:30',
                'place' => 'Театр ім. Кропивницького',
                'price' => 'від 150 ₴',
                'description' => [
                    'Прем\'єрна вистава сезону від трупи одного з найстаріших театрів України.',
                    'Квитки доступні онлайн та в касі театру.',
                ],
            ],
            [
                'slug' => 'nichnyj-kinopokaz',
                'image' => '/images/hero-city.png',
                'title' => 'Нічний кінопоказ просто неба',
                'category' => 'Кіно',
                'date' => '16 СЕР',
                'time' => '21:00',
                'place' => 'Дендропарк',
                'price' => '120 ₴',
                'description' => [
                    'Затишний кінопоказ під зорями у міському дендропарку.',
                    'Перед показом — коротка лекція про історію кіно від міського кіноклубу.',
                ],
            ],
            [
                'slug' => 'vystavka-suchasnoho-mystetstva',
                'image' => '/images/place-gallery.png',
                'title' => 'Виставка сучасного мистецтва',
                'category' => 'Виставка',
                'date' => '23 СЕР',
                'time' => '12:00',
                'place' => 'Галерея сучасного мистецтва',
                'price' => '80 ₴',
                'description' => [
                    'Нова виставка об\'єднує роботи молодих митців регіону.',
                    'Для відвідувачів проводитимуть кураторські екскурсії щовихідних.',
                ],
            ],
            [
                'slug' => 'simejnyj-den-u-parku',
                'image' => '/images/landmark-park.png',
                'title' => 'Сімейний день у парку',
                'category' => 'Родина',
                'date' => '30 СЕР',
                'time' => '11:00',
                'place' => 'Ковалівський парк',
                'price' => 'Безкоштовно',
                'description' => [
                    'День активного відпочинку для всієї родини: спортивні ігри, творчі майстерні, анімація для дітей.',
                    'Захід безкоштовний, реєстрація не потрібна.',
                ],
            ],
        ];

        foreach ($items as $item) {
            Event::create($item);
        }
    }

    private function seedPlaceCategories(): void
    {
        $categories = [
            ['key' => 'food', 'label' => 'Кафе та ресторани', 'icon' => 'UtensilsCrossed', 'description' => 'Кав\'ярні, ресторани, піцерії та заклади вуличної їжі міста.'],
            ['key' => 'shops', 'label' => 'Магазини та торгівля', 'icon' => 'ShoppingBag', 'description' => 'Торгові центри, книгарні, супермаркети та фірмові магазини.'],
            ['key' => 'culture', 'label' => 'Культура та дозвілля', 'icon' => 'Drama', 'description' => 'Театри, галереї, кінотеатри та концертні майданчики.'],
            ['key' => 'beauty', 'label' => 'Краса та здоров\'я', 'icon' => 'HeartPulse', 'description' => 'Салони краси, спа, стоматології та медичні центри.'],
            ['key' => 'education', 'label' => 'Освіта', 'icon' => 'GraduationCap', 'description' => 'Університети, школи, курси та дитячі розвиткові центри.'],
            ['key' => 'auto', 'label' => 'Авто та сервіс', 'icon' => 'Car', 'description' => 'Автосервіси, СТО, автомийки та шиномонтаж.'],
            ['key' => 'finance', 'label' => 'Фінанси та послуги', 'icon' => 'Briefcase', 'description' => 'Бізнес-центри, юридичні та фінансові компанії.'],
            ['key' => 'industry', 'label' => 'Промисловість', 'icon' => 'Factory', 'description' => 'Виробничі підприємства, фабрики та заводи міста.'],
        ];

        foreach ($categories as $cat) {
            PlaceCategory::create($cat);
        }
    }

    private function seedPlaces(): void
    {
        $places = [
            ['slug' => 'kavyarnya-ranok', 'image' => '/images/place-cafe.png', 'name' => 'Кав\'ярня «Ранок»', 'categoryKey' => 'food', 'rating' => '4.9', 'area' => 'Центр', 'address' => 'вул. Велика Перспективна, 24', 'hours' => '08:00 – 21:00', 'phone' => '+38 (052) 233-12-24', 'description' => ['Затишна кав\'ярня в самому центрі міста зі спеціальною кавою, авторськими десертами та ситними сніданками.', 'Тут зручно попрацювати за ноутбуком, зустрітися з друзями або просто насолодитися ранковою чашкою кави.']],
            ['slug' => 'restoran-inhul', 'image' => '/images/place-restaurant.png', 'name' => 'Ресторан «Інгул»', 'categoryKey' => 'food', 'rating' => '4.8', 'area' => 'Набережна', 'address' => 'вул. Набережна, 5', 'hours' => '11:00 – 23:00', 'phone' => '+38 (052) 240-05-05', 'description' => ['Ресторан сучасної української кухні з панорамним видом на річку.', 'Ідеальне місце для родинної вечері, ділової зустрічі чи святкування.']],
            ['slug' => 'restoran-teras', 'image' => '/images/place-restaurant.png', 'name' => 'Ресторан «Тераса»', 'categoryKey' => 'food', 'rating' => '4.6', 'area' => 'Історичний квартал', 'address' => 'вул. Дворцова, 22', 'hours' => '12:00 – 23:00', 'phone' => '+38 (052) 240-22-22', 'description' => ['Ресторан європейської кухні з відкритою терасою.', 'Сезонне меню, велика винна карта та жива музика щоп\'ятниці.']],
            ['slug' => 'pitseriya-vohnyshche', 'image' => '/images/place-cafe.png', 'name' => 'Піцерія «Вогнище»', 'categoryKey' => 'food', 'rating' => '4.7', 'area' => 'Ковалівка', 'address' => 'вул. Космонавта Попова, 8', 'hours' => '10:00 – 22:00', 'phone' => '+38 (052) 255-18-18', 'description' => ['Сімейна піцерія з піцою на дровах та великою дитячою зоною.', 'Швидка доставка містом та вигідні комбо-набори.']],
            ['slug' => 'tts-plaza', 'image' => '/images/cat-shops.png', 'name' => 'ТЦ «Плаза»', 'categoryKey' => 'shops', 'rating' => '4.5', 'area' => 'Центр', 'address' => 'вул. Велика Перспективна, 60', 'hours' => '10:00 – 21:00', 'phone' => '+38 (052) 260-00-60', 'description' => ['Найбільший торгово-розважальний центр міста.', 'Тут зібрані популярні бренди під одним дахом.']],
            ['slug' => 'knygarnya-slovo', 'image' => '/images/place-cafe.png', 'name' => 'Книгарня «Слово»', 'categoryKey' => 'shops', 'rating' => '4.8', 'area' => 'Центр', 'address' => 'вул. Велика Перспективна, 40', 'hours' => '09:00 – 20:00', 'phone' => '+38 (052) 233-40-40', 'description' => ['Сучасна книгарня з великим вибором української літератури.', 'При книгарні працює кав\'ярня та простір для зустрічей.']],
            ['slug' => 'market-svizhyj', 'image' => '/images/cat-shops.png', 'name' => 'Маркет «Свіжий»', 'categoryKey' => 'shops', 'rating' => '4.4', 'area' => 'Пацаєва', 'address' => 'вул. Пацаєва, 14', 'hours' => '08:00 – 22:00', 'phone' => '+38 (052) 271-14-14', 'description' => ['Супермаркет свіжих продуктів із власною пекарнею.', 'Щоденні акції та зона готової їжі.']],
            ['slug' => 'galereya-mystetstva', 'image' => '/images/place-gallery.png', 'name' => 'Галерея сучасного мистецтва', 'categoryKey' => 'culture', 'rating' => '4.7', 'area' => 'Історичний квартал', 'address' => 'вул. Дворцова, 17', 'hours' => '10:00 – 19:00', 'phone' => '+38 (052) 233-17-17', 'description' => ['Простір сучасного мистецтва з регулярними виставками.', 'Галерея підтримує молодих авторів регіону.']],
            ['slug' => 'teatr-kropyvnytskoho', 'image' => '/images/landmark-theatre.png', 'name' => 'Драматичний театр', 'categoryKey' => 'culture', 'rating' => '4.9', 'area' => 'Центр', 'address' => 'вул. Дворцова, 4', 'hours' => 'Каса 10:00 – 19:00', 'phone' => '+38 (052) 224-04-04', 'description' => ['Один із найстаріших театрів України.', 'У репертуарі — класичні та сучасні постановки.']],
            ['slug' => 'kinoteatr-zoryanyj', 'image' => '/images/hero-city.png', 'name' => 'Кінотеатр «Зоряний»', 'categoryKey' => 'culture', 'rating' => '4.5', 'area' => 'Ковалівка', 'address' => 'вул. Космонавта Попова, 20', 'hours' => '09:00 – 00:00', 'phone' => '+38 (052) 255-20-20', 'description' => ['Сучасний кінотеатр із залами Dolby Atmos.', 'Онлайн-бронювання квитків.']],
            ['slug' => 'salon-lyuks', 'image' => '/images/cat-beauty.png', 'name' => 'Салон краси «Люкс»', 'categoryKey' => 'beauty', 'rating' => '4.9', 'area' => 'Центр', 'address' => 'вул. Шевченка, 12', 'hours' => '09:00 – 20:00', 'phone' => '+38 (052) 233-90-12', 'description' => ['Повний спектр послуг: перукарня, манікюр, косметологія.', 'Онлайн-запис та професійна косметика.']],
            ['slug' => 'spa-harmoniya', 'image' => '/images/cat-beauty.png', 'name' => 'СПА-центр «Гармонія»', 'categoryKey' => 'beauty', 'rating' => '4.8', 'area' => 'Набережна', 'address' => 'вул. Набережна, 18', 'hours' => '10:00 – 22:00', 'phone' => '+38 (052) 240-18-18', 'description' => ['Простір релаксу з масажем, сауною та водними процедурами.', 'Комплексні програми відновлення.']],
            ['slug' => 'stomatologiya-denta', 'image' => '/images/cat-beauty.png', 'name' => 'Стоматологія «Дента»', 'categoryKey' => 'beauty', 'rating' => '4.9', 'area' => 'Центр', 'address' => 'вул. Велика Перспективна, 33', 'hours' => '09:00 – 19:00', 'phone' => '+38 (052) 233-33-33', 'description' => ['Сучасна стоматологічна клініка з цифровою діагностикою.', 'Дитяча стоматологія та імплантація.']],
            ['slug' => 'universytet', 'image' => '/images/cat-education.png', 'name' => 'Центральноукраїнський університет', 'categoryKey' => 'education', 'rating' => '4.7', 'area' => 'Центр', 'address' => 'вул. Шевченка, 1', 'hours' => '08:00 – 18:00', 'phone' => '+38 (052) 224-01-01', 'description' => ['Провідний заклад вищої освіти регіону.', 'Сучасні лабораторії та програми міжнародного обміну.']],
            ['slug' => 'shkola-speak-up', 'image' => '/images/cat-education.png', 'name' => 'Школа англійської «Speak Up»', 'categoryKey' => 'education', 'rating' => '4.8', 'area' => 'Центр', 'address' => 'вул. Дворцова, 30', 'hours' => '10:00 – 20:00', 'phone' => '+38 (052) 233-30-30', 'description' => ['Курси англійської для дітей і дорослих.', 'Групові й індивідуальні заняття.']],
            ['slug' => 'avtoservis-motors', 'image' => '/images/cat-auto.png', 'name' => 'Автосервіс «Моторс»', 'categoryKey' => 'auto', 'rating' => '4.7', 'area' => 'Промзона', 'address' => 'вул. Мурманська, 5', 'hours' => '08:00 – 20:00', 'phone' => '+38 (052) 277-05-05', 'description' => ['Повний цикл обслуговування авто.', 'Оригінальні запчастини та гарантія.']],
            ['slug' => 'biznes-tsentr-portal', 'image' => '/images/cat-finance.png', 'name' => 'Бізнес-центр «Портал»', 'categoryKey' => 'finance', 'rating' => '4.6', 'area' => 'Центр', 'address' => 'вул. Велика Перспективна, 1', 'hours' => '09:00 – 19:00', 'phone' => '+38 (052) 233-01-01', 'description' => ['Сучасний бізнес-центр класу B+.', 'Коворкінг та переговорні кімнати.']],
            ['slug' => 'mebleva-fabryka-dub', 'image' => '/images/cat-industry.png', 'name' => 'Меблева фабрика «Дуб»', 'categoryKey' => 'industry', 'rating' => '4.7', 'area' => 'Промзона', 'address' => 'вул. Мурманська, 20', 'hours' => '08:00 – 17:00', 'phone' => '+38 (052) 277-20-20', 'description' => ['Виробництво меблів на замовлення з натуральних матеріалів.', 'Власне конструкторське бюро та доставка.']],
        ];

        foreach ($places as $place) {
            $categoryKey = $place['categoryKey'];
            unset($place['categoryKey']);

            $category = PlaceCategory::where('key', $categoryKey)->first();
            $place['category_id'] = $category->id;

            Place::create($place);
        }
    }

    private function seedLandmarks(): void
    {
        $items = [
            [
                'slug' => 'dramatychnyj-teatr',
                'image' => '/images/landmark-theatre.png',
                'title' => 'Драматичний театр',
                'description' => 'Один із найстаріших театрів України, заснований Марком Кропивницьким.',
                'body' => [
                    'Театр має понад столітню історію і вважається колискою українського професійного театру.',
                    'Сьогодні це один із культурних центрів міста з насиченим репертуаром.',
                ],
            ],
            [
                'slug' => 'dendropark',
                'image' => '/images/landmark-park.png',
                'title' => 'Дендропарк і фонтани',
                'description' => 'Зелене серце міста з тінистими алеями та історичними фонтанами.',
                'body' => [
                    'Дендропарк — улюблене місце відпочинку містян.',
                    'У парку регулярно проходять фестивалі, ярмарки та сімейні заходи.',
                ],
            ],
        ];

        foreach ($items as $item) {
            Landmark::create($item);
        }
    }

    private function seedTransportRoutes(): void
    {
        $items = [
            ['number' => '1', 'type' => 'Тролейбус', 'route_from' => 'Залізничний вокзал', 'route_to' => 'вул. Космонавта Попова', 'interval' => '8–12 хв'],
            ['number' => '3', 'type' => 'Тролейбус', 'route_from' => 'Центр', 'route_to' => 'Житломасив «Ковалівка»', 'interval' => '10–15 хв'],
            ['number' => '9', 'type' => 'Електробус', 'route_from' => 'Аеропорт', 'route_to' => 'Центральна площа', 'interval' => '12–18 хв'],
            ['number' => '14', 'type' => 'Автобус', 'route_from' => 'Пацаєва', 'route_to' => 'Лікарня швидкої допомоги', 'interval' => '10–14 хв'],
            ['number' => '27', 'type' => 'Маршрутка', 'route_from' => 'Гірниче', 'route_to' => 'Центральний ринок', 'interval' => '6–10 хв'],
            ['number' => '150', 'type' => 'Автобус', 'route_from' => 'Кропивницький', 'route_to' => 'Знам\'янка', 'interval' => '20–30 хв'],
        ];

        foreach ($items as $item) {
            TransportRoute::create($item);
        }
    }

    private function seedServiceGroups(): void
    {
        $groups = [
            [
                'category' => 'Документи та реєстрація',
                'items' => [
                    ['icon' => 'FileText', 'title' => 'Довідки та витяги', 'description' => 'Замовлення довідок про склад сім\'ї, місце проживання онлайн.', 'action' => 'Замовити довідку'],
                    ['icon' => 'Home', 'title' => 'Реєстрація місця проживання', 'description' => 'Подання заяви на реєстрацію без черг у ЦНАПі.', 'action' => 'Подати заяву'],
                    ['icon' => 'Baby', 'title' => 'Реєстрація новонароджених', 'description' => 'Оформлення документів за принципом «єМалятко».', 'action' => 'Оформити'],
                ],
            ],
            [
                'category' => 'Житло та комунальні послуги',
                'items' => [
                    ['icon' => 'Receipt', 'title' => 'Оплата комунальних', 'description' => 'Сплата за воду, тепло, вивіз сміття в один клік.', 'action' => 'Сплатити'],
                    ['icon' => 'Wrench', 'title' => 'Заявка на ремонт', 'description' => 'Повідомити про ями на дорогах, зламане освітлення.', 'action' => 'Створити заявку'],
                    ['icon' => 'HandCoins', 'title' => 'Субсидії та пільги', 'description' => 'Оформлення житлових субсидій.', 'action' => 'Дізнатися більше'],
                ],
            ],
            [
                'category' => 'Громада та звернення',
                'items' => [
                    ['icon' => 'MessageSquare', 'title' => 'Звернення до міськради', 'description' => 'Офіційні звернення, петиції та запити.', 'action' => 'Звернутися'],
                    ['icon' => 'Vote', 'title' => 'Громадський бюджет', 'description' => 'Подання та голосування за проєкти.', 'action' => 'До проєктів'],
                    ['icon' => 'Phone', 'title' => 'Контакт-центр 1580', 'description' => 'Цілодобова гаряча лінія міста.', 'action' => 'Зателефонувати'],
                ],
            ],
        ];

        foreach ($groups as $position => $group) {
            $serviceGroup = ServiceGroup::create([
                'category' => $group['category'],
                'position' => $position + 1,
            ]);

            foreach ($group['items'] as $itemPosition => $item) {
                ServiceItem::create([
                    'service_group_id' => $serviceGroup->id,
                    'icon' => $item['icon'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'action' => $item['action'],
                    'position' => $itemPosition + 1,
                ]);
            }
        }
    }
}
