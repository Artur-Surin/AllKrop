# Транспортний модуль EasyWay для All Kropyvnytskiy

## Мета

Необхідно реалізувати транспортний модуль для сайту All Kropyvnytskiy на Laravel.

Модуль повинен працювати через EasyWay API та підтримувати:

- карту
- GPS транспорту
- зупинки
- маршрути
- пошук маршруту А → Б
- онлайн табло
- інформацію про маршрути

---

# Архітектура

Створити папку

app/Services/EasyWay

```
EasyWayClient.php

GeneralService.php

RouteService.php

StopService.php

SearchService.php
```

Створити контролери

```
GeneralController

RouteController

StopController

SearchController
```

Створити config

```
config/services.php

'easyway' => [
    'login' => env('EASYWAY_LOGIN'),
    'password' => env('EASYWAY_PASSWORD'),
    'url' => 'https://api.eway.in.ua/'
]
```

.env

```
EASYWAY_LOGIN=
EASYWAY_PASSWORD=
```

---

# EasyWayClient

Створити один HTTP Client.

Всі сервіси використовують тільки його.

Використовувати

```
Http::timeout(15)
```

Обробляти

- timeout
- 500
- invalid login
- invalid city

---

# Cache

Закешувати

General.GetSystemInfo

на 7 днів

RouteInfo

на 24 години

StopInfo

на 1 годину

GPS

не кешувати

---

# API

## 1

general.GetSystemInfo

повертає

- міста
- типи транспорту
- типи маршрутів
- доступні функції

Метод

```
GeneralService::getSystemInfo()


Описание:
Возвращает список доступных в системе функций, городов, типов транспорта и маршрута

Пример запроса:
?
1
2
3
4
https://api.eway.in.ua/?
login=login&password=pass
&function=general.GetSystemInfo
&format=xml
Входные параметры:
нет

Ответ сервера:
Пример ответа сервера

Тег	Описание
functions	Список доступных в системе функций function
function	Информация о функции:
key - название функции
cities	Список доступных в системе городов city
city	Информация о городе:
title - название города
key - ID города в системе
transports	Список доступных в системе типов транспорта transport
transport	Тип транспорта
key - ID типа транспорта
type	Спиcок доступных в системе типов маршрута
key - ID типа маршрута
```

---

## 2

routes.GetRoutesNearPoint

параметри

city

lat

lng

radius

повертає

масив маршрутів

```
RouteService::getRoutesNearPoint()

Описание:
Возвращает список маршрутов, проходящих в окрестности заданной точки

Пример запроса:
?
1
2
3
4
5
6
https://api.eway.in.ua/?
login=login&password=pass
&function=routes.GetRoutesNearPoint
&city=lviv
&lat=49.822369370108206
&lng=23.960023651123038
Входные параметры:
Имя параметра	Описание
city	(обязательный параметр)
ID города
lat, lng	(обязательные параметры)
Координаты точки
r	Радиус поиска, принимает значение от 100 до 1000 метров.
По умолчанию r=300

Ответ сервера: 
Пример ответа сервера

Тег	Описание
routes	Массив маршрутов route
route	Маршрут:
type - тип транспорта
title - название маршрута
```

---

## 3

stops.GetStopsNearPoint

повертає

зупинки

```
StopService::getStopsNearPoint()

Описание:
Возвращает список остановок, находящихся в окрестности заданной точки

Пример запроса:
?
1
2
3
4
5
6
https://api.eway.in.ua/?
login=login&password=pass
&function=stops.GetStopsNearPoint
&city=lviv
&lat=49.822369370108206
&lng=23.960023651123038
Входные параметры:
Имя параметра	Описание
city	(обязательный параметр)
ID города
lat, lng	(обязательные параметры)
Координаты точки
r	Радиус поиска, принимает значение от 100 до 1000 метров.
По умолчанию r=300

Ответ сервера:
Пример ответа сервера

Тег	Описание
stop	
Массив остановок:

lat, lng - координаты
title - название
```

---

## 4

routes.GetRouteInfo

повертає

номер

тип

вартість

опис

інтервал

час роботи

```
RouteService::getRouteInfo()

Опис:
Повертає детальну інформацію про маршрут

Приклад запиту:
?
1
2
3
4
5
https://api.eway.in.ua/?
login=login&password=pass
&function=routes.GetRouteInfo
&city=dnipropetrovsk
&id=309
Вхідні дані:
Им"я параметра	Опис
city	(обов"язковий параметр)
ID міста
id	(обов"язковий параметр)
ID маршруту в системі 
Відповідь сервера:
Приклад відповіді сервера

Тег	Опис
routeinfo	Інформація про маршрут:
shortDescription - назва маршруту
transportType - тип транспорту
price - вартість проїзду
interval - інтервал руху
workTime - час роботи
number - номер маршруту
description - перелік вулиць слідування
```

---

## 5

routes.GetRouteGPS

повертає

ID

lat

lng

direction

data_relevance

показувати тільки

data_relevance=1

оновлення

кожні 10 секунд

```
RouteService::getGPS()

Опис:
Повертає GPS дані місцезнаходження транспорту на маршруті

Приклад запиту:
?
1
2
3
4
5
https://api.eway.in.ua/?
login=login&password=pass
&function=routes.GetRouteGPS
&city=lviv
&id=123
Вхідні параметри:
Назва параметру	Опис
city	(обов"язковий параметр)
ID міста
ID	(обов"язковий параметр)
ID маршруту
Відповідь сервера:
Приклад відповіді

Тег	Опис
vehicle	Транспортний засіб:
ID - унікальний ідентифікатор
name - назва
lat, lng - координати
direction - напрям руху
data_relevance - актуальність даних
Direction може набувати одне з наступних значень:

-1 - напрямок визначити неможливо
0 - напрямок не визначено (автобус рухається не по маршруту, недостатьо даних для визначення напрямку тощо)
1 - прямий маршрут
2- зворотній маршрут
Data_relevance може набувати одне з наступних значень:

0 - дані не актуальні (останнє оновлення відбулось невдало. У цьому випадку приходить остання вдало збережена інформація)
1 - дані в актуальному стані
```

---

## 6

stops.GetStopInfo

повертає

назву

координати

маршрути

час прибуття

next_vehicle

second_vehicle

```
StopService::getStopInfo()

Опис:
Повертає детальна інформація про зупинки, онлайн табло прибуття, якщо доступне

Приклад запиту:
?
1
2
3
4
5
https://api.eway.in.ua/?
login=login&password=pass
&function=stops.GetStopInfo
&city=lviv
&id=123
Вхідні параметри:
Назва параметру	Опис
city	(обов"язковий параметр)
ID міста
ID	(обов"язковий параметр)
ID зупинки
Відповідь сервера:
Приклад відповіді

Тег	Опис
stop	Інформація про зупинку:
title - назва
lat, lng - координати
а також масив transports

transports	перелік маршрутів, що зупиняються на зупинці, погрупованих по типу транспорту
transport	Інформація про тип транспорту:
id - унікальний ідентифікатор
key - коротка назва
name - назва
routes	Інформація про маршрут:
id - унікальний ідентифікатор
title - назва
has_gps - чи GPS дані в наявності?
direction - напрям руху
next_vehicle - час прибуття першого транспортного засобу, хв
second_vehicle - час прибуття наступного транспортного засобу, хв
```

---

## 7

routes.Search

будує маршрут

від

до

повертає

маршрути

пересадки

час

вартість

start_position

stop_position

```
SearchService::search()

Описание:
Возвращает варианты проезда из А в Б на общественном транспорте

Пример запроса:
?
1
2
3
4
5
6
7
8
https://api.eway.in.ua/?
login=login&password=pass
&function=routes.Search
&city=donetsk
&start_lat=48.03676802&start_lng=37.71427346
&stop_lat=47.99128114&stop_lng=37.79573751
&transports=bus,trol
&format=xml
Входные параметры:
Название параметра	Описание
city	(обязательный параметр)
ID города
start_lat, start_lng	(обязательные параметры)
Координаты точки От
stop_lat, stop_lng	(обязательные параметры)
Координаты точки До
transports	Типы транспорта, перечисляются через запятую. Список актуальных значений возвращает функция general.GetSystemInfo
По умолчанию активны все типы общественного транспорта. Несуществующие для конкретного города значения types также игнорируются

type	Тип маршрута, список актуальных значений возвращает функция general.GetSystemInfo
По умолчанию type=optimal

direct	Поиск маршрутов без пересадок, возможные значения true или false.
По умолчанию direct=false

results_count	Количество возвращаемых вариантов пути, число от 1 до 25
По умолчанию results_count=10

Ответ сервера:
Пример ответа сервера

Название тега	Описание
ways	Массив найденных вариантов пути way, а также набор остановок stop_titles
way	Начальная и конечные остановки пути, массив маршрутов routes
stop type = "foot_to|foot_from"	Пешие маршруты от точки От до начальной остановки или от конечной остановки до точки До
id - ID остановки в массиве stop_titles
distance - расстояние в метрах
time - время передвижения в минутах
routes	Перечень маршрутов общественного транспорта route, а также информацию о пересадках между ними transfer
route index="n"	Маршрут общественного транспорта, index="n" - порядок следования маршрута в пути
id - ID маршрута
start_position - начальная точка маршрута
stop_position - конечная точка маршрута
title - номер маршрута
type - тип транспорта 
time - общее время движения
price - стоимость проезда
interval - интервал движения маршрута
а также сведения о начале и конце движения на заданном маршруте stop
stop type="in|out"	Начальная type="in" и конечная type="out" остановки для движения на заданном маршруте. Содержит ID остановки в массиве stop_titles
transfer	Остановки stop, на которых происходит пересадка, расстояние и время движения между ними:
distance - расстояние между остановками
time - время движения
stop type="from|to"	Начальная остановка from и конечная остановка to пересадки
id - ID остановки в массиве stop_names
type - тип транспорта
number - номер маршрута
stop_titles	Массив остановок stop, в котором содержится каждая остановка любого из вариантов пути 
stop id="n"	Информация о конкретной остановке, содержит ее название на нужном языке
```

---

## 8

routes.GetRouteToDisplay

отримує

id

start_position

stop_position

повертає

масив точок

намалювати

Leaflet Polyline

Описание:
Возвращает часть маршрута для отображения на карте. Эта функция используется в паре с routes.Search, которая и предоставляет значения необходимых входных параметров

Пример запроса:
?
1
2
3
4
5
6
7
https://api.eway.in.ua/?
login=login&password=pass
&function=routes.GetRouteToDisplay
&city=dnipropetrovsk
&id=309
&start_position=81
&stop_position=138
Входные параметры:
Имя параметра	Описание
city	(обязательный параметр)
ID города
id	(обязательный параметр)
Id маршрута в системе 
start_position, stop_position	(обязательные параметры)
Начало и конец участка маршрута, который необходимо нарисовать на карте
Ответ сервера:
Пример ответа сервера

Тег	Описание
route	Информация о маршруте:
title - номер маршрута
type - тип транспорта
а также массив точек points 

points	Массив точек point для отображения маршрута на карте. Точка может быть либо остановкой is_stop="true" либо направляющей линии маршрута is_stop="false"
point is_stop="true"	Остановка:
lat, lng - координаты
title - название остановки
point is_stop="false"	Направляющая точка линии маршрута:
lat, lng - координаты

---

# API сайту

GET

/api/routes/near

GET

/api/stops/near

GET

/api/routes/{id}

GET

/api/routes/{id}/gps

GET

/api/stops/{id}

POST

/api/search

---

# Frontend

Карта Leaflet

Показати

- GPS
- маршрути
- зупинки

По кліку

маршрут

відкрити

інформацію

По кліку

зупинка

відкрити

табло

---

# Search

Користувач вводить

Звідки

Куди

Laravel

↓

routes.Search

↓

отримує

start_position

stop_position

↓

routes.GetRouteToDisplay

↓

малює маршрут

---

# Карта

Leaflet

OpenStreetMap

Маркери

Автобус

Тролейбус

Трамвай

Polyline

для маршруту

---

# Redis

Використовувати

Cache::remember()

---

# SOLID

Використовувати

Repository не потрібен.

Вся логіка повинна знаходитися в Services.

Контролери повинні бути тонкими.

---

# Вимоги

Код повинен відповідати

PSR-12

SOLID

DRY

KISS

Використовувати Dependency Injection.

Не дублювати HTTP запити.

---

# Реалізувати

✔ карта

✔ GPS

✔ маршрути

✔ зупинки

✔ онлайн табло

✔ сторінка маршруту

✔ сторінка зупинки

✔ пошук маршруту

✔ маршрут на карті

✔ кеш

✔ обробку помилок

✔ логування

✔ DTO (за бажанням)

✔ Unit tests (за бажанням)