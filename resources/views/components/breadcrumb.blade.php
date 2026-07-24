@props(['items' => []])

@if(count($items) > 0)
@php
    $schemaItems = collect($items)->map(function ($item, $index) use ($items) {
        $data = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['label'],
        ];
        if (isset($item['href'])) {
            $data['item'] = $item['href'];
        }
        return $data;
    })->toArray();
@endphp
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $schemaItems,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<nav aria-label="Хлібні крихти" {{ $attributes }}>
    <ol class="flex items-center gap-1.5 text-sm text-muted-foreground">
        @foreach($items as $item)
            @if($loop->first && isset($item['href']))
                <li><a href="{{ $item['href'] }}" class="transition-colors hover:text-foreground">{{ $item['label'] }}</a></li>
            @elseif($loop->last)
                <li aria-current="page">
                    <span class="font-medium text-foreground">{{ $item['label'] }}</span>
                </li>
            @else
                <li class="flex items-center gap-1.5">
                    <x-icon name="ChevronRight" class="h-3.5 w-3.5" />
                    @if(isset($item['href']))
                        <a href="{{ $item['href'] }}" class="transition-colors hover:text-foreground">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif
