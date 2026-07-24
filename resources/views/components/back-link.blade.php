@props(['href', 'label' => 'Назад'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground']) }}>
    <x-icon name="ArrowLeft" class="h-4 w-4" />
    {{ $label }}
</a>
