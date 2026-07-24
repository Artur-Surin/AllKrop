# SEO & Accessibility Rules

## Meta Tags

Every page MUST include in `<head>`:

```html
<title>{{ $pageTitle }} — Кропивницький Портал</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="uk_UA">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ asset('images/og-default.jpg') }}">
```

- Use a Blade component `components/meta.blade.php` to inject these consistently
- Every page provides `@section('meta-title')`, `@section('meta-description')`
- OG image: 1200x630px, < 5MB, JPG/PNG

## Structured Data (JSON-LD)

Include JSON-LD `<script type="application/ld+json">` blocks per page type:

| Page Type        | Schema Type       | Required Properties |
|------------------|-------------------|---------------------|
| Homepage         | `WebSite`         | name, url, potentialAction |
| News article     | `NewsArticle`     | headline, datePublished, author, image |
| Event            | `Event`           | name, startDate, location, description |
| Place page       | `LocalBusiness`   | name, address, geo, openingHours |
| Breadcrumb       | `BreadcrumbList`  | itemListElement with position, name, item |
| All pages        | (include breadcrumb) | — |

Place JSON-LD in `@section('json-ld')` block per page, rendered in layout.

## Canonical URLs

- Every page has `<link rel="canonical" href="...">`
- Use `url()->current()` as default canonical
- For paginated pages, canonical points to the first page
- For filtered/sorted pages, canonical excludes query params

## Sitemap

- Generate XML sitemap at `/sitemap.xml`
- Use `spatie/laravel-sitemap` or build dynamically from controllers
- Include: homepage, all places, all news, all events, static pages
- Reference in `robots.txt`:

```
User-agent: *
Allow: /
Sitemap: https://krop-portal.example.ua/sitemap.xml
```

- Update sitemap on model save/delete via observer or job

## Semantic HTML

Use proper HTML5 semantic elements:

```html
<header>       <!-- site-wide header, nav -->
<nav>          <!-- navigation blocks -->
<main>         <!-- primary content, one per page -->
<article>      <!-- self-contained content (news, events) -->
<section>      <!-- thematic grouping within a page -->
<aside>        <!-- sidebar, related content -->
<footer>       <!-- site-wide footer -->
<figure>       <!-- images with captions -->
<figcaption>   <!-- image caption text -->
```

- Never use `<div>` where a semantic element exists
- One `<h1>` per page, heading hierarchy in order (h1 → h2 → h3)

## ARIA Attributes

| Element / Pattern | Attribute | Value |
|-------------------|-----------|-------|
| Interactive buttons | `aria-label` | Descriptive label |
| Expandable menu | `aria-expanded` | `true` / `false` |
| Filter toggle | `aria-pressed` | `true` / `false` |
| Live region (search results) | `aria-live` | `polite` |
| Decorative icon | `aria-hidden` | `true` |
| Modal/dialog | `role="dialog"`, `aria-modal` | `true` |
| Navigation | `role="navigation"`, `aria-label` | Section name |

- Always pair `aria-expanded` with a visible toggle indicator
- Use `aria-current="page"` on active nav links

## Focus Management

- All interactive elements have visible `:focus-visible` outline
- Focus ring: `focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2`
- Skip-to-content link: first element in `<body>`, visible on focus only:

```html
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute ...">
  Перейти до вмісту
</a>
```

- Focus trapped in modals/dialogs when open
- Focus returned to trigger element when modal closes

## Images

- Every `<img>` has a descriptive `alt` attribute
- Decorative images: `alt=""` and `aria-hidden="true"`
- Lazy loading: `loading="lazy"` on below-the-fold images
- Prevent CLS: always include `width` and `height` attributes
- Use `srcset` and `sizes` for responsive images when possible
- WebP/AVIF with fallbacks for broad browser support

## Forms

- Every `<input>` has an associated `<label>` (`for`/`id` pairing)
- Required fields: `required` attribute + visual indicator
- Error messages: `<span role="alert" aria-live="assertive">` near the input
- Group related inputs with `<fieldset>` and `<legend>`
- Inline validation: announce errors with `aria-live="polite"` for screen readers
- Submit buttons have descriptive text, not just "Submit"

## Tables

- Every `<table>` has a `<caption>` describing its content
- Header cells use `scope="col"` (column) or `scope="row"` (row)
- Responsive: wrap in `<div class="overflow-x-auto">` for mobile
- Use `tabindex="0"` on scrollable tables for keyboard access

## Motion / Reduced Motion

- Respect `prefers-reduced-motion` media query
- Wrap all animations in:

```css
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

- Parallax, auto-playing carousels, and infinite scroll must be pausable
- Provide a toggle in the UI for users to disable animations

## Language & Locale

- `<html lang="uk">` on all pages
- `hreflang="uk"` for Ukrainian content
- Consistent use of Ukrainian language in UI text
