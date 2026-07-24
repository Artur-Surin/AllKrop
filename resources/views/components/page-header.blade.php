@props(['eyebrow', 'title', 'description' => null, 'crumbs' => null])

<section class="border-b border-border bg-secondary/40 py-10 sm:py-14">
    <div class="mx-auto max-w-5xl px-4 sm:px-6">
        @if($crumbs && count($crumbs) > 0)
            <x-breadcrumb :items="$crumbs" class="mb-6" />
        @endif

        <p class="text-sm font-medium text-primary">{{ $eyebrow }}</p>

        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">{{ $title }}</h1>

        @if($description)
            <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">{{ $description }}</p>
        @endif
    </div>
</section>
