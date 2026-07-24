# SEO Optimizer Agent

## Task

Add comprehensive SEO metadata, structured data, and sitemap to every page of the Kropyvnytskyi city portal, targeting a Lighthouse SEO score > 90.

## Meta Component

Create `resources/views/components/meta.blade.php`:

```blade
@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'publishedTime' => null,
    'modifiedTime' => null,
    'author' => null,
])

@php
    $pageTitle = $title ? $title . ' — Кропивницький Портал' : 'Кропивницький Портал — Все про місто';
    $pageDescription = $description ?? 'Інформаційний портал міста Кропивницький: новини, події, місця, транспорт, послуги';
    $pageImage = $image ?? asset('images/og-default.jpg');
    $pageUrl = url()->current();
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<link rel="canonical" href="{{ $pageUrl }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:locale" content="uk_UA">
<meta property="og:site_name" content="Кропивницький Портал">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">

@if ($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
@endif
@if ($modifiedTime)
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
@endif
@if ($author)
    <meta property="article:author" content="{{ $author }}">
@endif
```

## Usage in Layout

In `resources/views/layouts/app.blade.php` `<head>`:

```blade
<x-meta
    :title="$metaTitle ?? null"
    :description="$metaDescription ?? null"
    :image="$metaImage ?? null"
    :type="$metaType ?? 'website'"
    :published-time="$metaPublishedTime ?? null"
    :modified-time="$metaModifiedTime ?? null"
/>
```

## JSON-LD Structured Data

### Component: `components/json-ld.blade.php`

```blade
@props(['data'])

<script type="application/ld+json">
{!! json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
```

### Per-Page Schema

**Homepage (`home.blade.php`):**
```blade
<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'Кропивницький Портал',
    'url' => url('/'),
    'description' => 'Інформаційний портал міста Кропивницький',
    'inLanguage' => 'uk',
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => url('/search?q={search_term_string}'),
        'query-input' => 'required name=search_term_string',
    ],
]" />
```

**News article (`news/show.blade.php`):**
```blade
<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $news->title,
    'description' => $news->excerpt,
    'image' => $news->image ? asset('storage/' . $news->image) : null,
    'datePublished' => $news->published_at->toIso8601String(),
    'dateModified' => $news->updated_at->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => 'Кропивницький Портал'],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Кропивницький Портал',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
    ],
    'mainEntityOfPage' => url()->current(),
]" />
```

**Event (`events/show.blade.php`):**
```blade
<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'Event',
    'name' => $event->title,
    'description' => $event->description,
    'image' => $event->image ? asset('storage/' . $event->image) : null,
    'startDate' => $event->starts_at->toIso8601String(),
    'endDate' => $event->ends_at?->toIso8601String(),
    'location' => $event->location ? [
        '@type' => 'Place',
        'name' => $event->location,
    ] : null,
    'offers' => $event->is_free ? [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'UAH',
    ] : null,
]" />
```

**Place (`places/show.blade.php`):**
```blade
<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => $place->name,
    'description' => $place->description,
    'image' => $place->image ? asset('storage/' . $place->image) : null,
    'address' => $place->address ? [
        '@type' => 'PostalAddress',
        'streetAddress' => $place->address,
        'addressLocality' => 'Кропивницький',
        'addressCountry' => 'UA',
    ] : null,
    'geo' => ($place->latitude && $place->longitude) ? [
        '@type' => 'GeoCoordinates',
        'latitude' => $place->latitude,
        'longitude' => $place->longitude,
    ] : null,
    'telephone' => $place->phone,
    'url' => $place->website,
]" />
```

**Breadcrumb (all pages):**
```blade
@php
    $breadcrumbs = [
        ['name' => 'Головна', 'item' => url('/')],
        // ... page-specific crumbs
    ];
@endphp

<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($breadcrumbs)->map(fn ($crumb, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['name'],
        'item' => $crumb['item'],
    ])->toArray(),
]" />
```

## Sitemap

Create route in `routes/web.php`:

```php
Route::get('/sitemap.xml', function () {
    $news = \App\Models\News::where('is_published', true)->get();
    $events = \App\Models\Event::where('is_published', true)->get();
    $places = \App\Models\Place::where('is_published', true)->get();
    $landmarks = \App\Models\Landmark::where('is_published', true)->get();

    $xml = response()->view('sitemap', compact('news', 'events', 'places', 'landmarks'))
        ->header('Content-Type', 'application/xml');

    return $xml;
})->name('sitemap');
```

Create `resources/views/sitemap.blade.php`:

```blade
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach ($news as $item)
    <url>
        <loc>{{ route('news.show', $item->slug) }}</loc>
        <lastmod>{{ $item->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @foreach ($events as $item)
    <url>
        <loc>{{ route('events.show', $item->slug) }}</loc>
        <lastmod>{{ $item->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    @foreach ($places as $item)
    <url>
        <loc>{{ route('places.show', $item->slug) }}</loc>
        <lastmod>{{ $item->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
    @foreach ($landmarks as $item)
    <url>
        <loc>{{ route('landmarks.show', $item->slug) }}</loc>
        <lastmod>{{ $item->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
```

## robots.txt

Update `public/robots.txt`:

```
User-agent: *
Allow: /
Disallow: /admin
Disallow: /filament

Sitemap: {{ url('/sitemap.xml') }}
```

## Semantic HTML Checklist

Ensure every page uses:

- `<html lang="uk">`
- `<header>` for site header
- `<nav>` with `aria-label` for navigation
- `<main id="main-content">` as the main content wrapper
- `<article>` for news/event detail pages
- `<section>` for thematic groupings
- `<footer>` for site footer
- Skip-to-content link as first child of `<body>`

## Accessibility Checklist

- All images have descriptive `alt` text
- All interactive elements have `:focus-visible` outline
- `aria-label` on all icon-only buttons
- `aria-expanded` on mobile menu toggle
- `aria-live="polite"` on search results container
- Forms have associated `<label>` elements
- Error messages use `role="alert"`
- `prefers-reduced-motion` disables animations

## Verification

```bash
# Check sitemap renders
curl http://localhost:8000/sitemap.xml

# Check meta tags in page source
curl -s http://localhost:8000 | grep -o '<meta[^>]*>'

# Run Lighthouse
npx lighthouse http://localhost:8000 --only-categories=seo --output=json
```

- Lighthouse SEO score > 90
- All pages have `<title>`, `<meta description>`, `<link rel="canonical">`
- OG tags present and correct
- JSON-LD validates (test with Google Rich Results Test)
- `/sitemap.xml` returns valid XML
- `robots.txt` references sitemap
- No broken internal links
- All images have `alt` attributes
- All forms have labels

## File Locations

```
resources/views/components/meta.blade.php
resources/views/components/json-ld.blade.php
resources/views/sitemap.blade.php
public/robots.txt
routes/web.php (sitemap route)
resources/views/layouts/app.blade.php (meta inclusion)
```
