@props([
    'title' => 'Кропивницький — міський портал',
    'description' => 'Все про місто Кропивницький: новини, афіша подій, довідник закладів та туристичний гід.',
    'url' => null,
    'image' => null,
    'type' => 'website',
    'noIndex' => false,
])

@php
    $url = $url ?? request()->url();
    $siteName = 'Кропивницький — міський портал';
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if($noIndex)
    <meta name="robots" content="noindex">
@endif
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($image)
    <meta property="og:image" content="{{ $image }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif
