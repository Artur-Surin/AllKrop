@props(['items' => []])

@if(count($items) > 0)
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
