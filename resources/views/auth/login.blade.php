@extends('layouts.app')

@section('title', 'Вхід — Кропивницький міський портал')

@section('content')
<main id="main-content" class="py-12 md:py-20">
    <div class="mx-auto max-w-md px-4 sm:px-6">
        <div class="rounded-3xl border border-border bg-card p-6 shadow-xl sm:p-8">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h1 class="font-serif text-2xl font-bold tracking-tight text-foreground">Вхід в акаунт</h1>
                <p class="mt-1 text-sm text-muted-foreground">Авторизуйтесь, щоб додавати свої заклади та керувати ними</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-destructive/10 p-4 text-sm text-destructive">
                    <ul class="list-disc space-y-1 pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-foreground">Email адреса</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="your@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-foreground">Пароль</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-border text-primary focus:ring-primary">
                        <span class="text-xs text-muted-foreground">Запам'ятати мене</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-primary py-3 text-sm font-semibold text-primary-foreground shadow-md transition-all hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20 active:scale-[0.99]">
                    Увійти
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-muted-foreground">
                Немає акаунту?
                <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Зареєструватися</a>
            </div>
        </div>
    </div>
</main>
@endsection
