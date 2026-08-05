@extends('layouts.app')

@section('title', 'Реєстрація — Кропивницький міський портал')

@section('content')
<main id="main-content" class="py-12 md:py-20">
    <div class="mx-auto max-w-md px-4 sm:px-6">
        <div class="rounded-3xl border border-border bg-card p-6 shadow-xl sm:p-8">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h1 class="font-serif text-2xl font-bold tracking-tight text-foreground">Створення акаунту</h1>
                <p class="mt-1 text-sm text-muted-foreground">Зареєструйтеся для додавання закладів Кропивницького</p>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-foreground">Ім'я та Прізвище / Назва компанії</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="Олександр Коваль">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-foreground">Email адреса</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="your@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-foreground">Пароль</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="Мінімум 8 символів">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-foreground">Підтвердження пароля</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1.5 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground transition-colors focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="Повторіть пароль">
                </div>

                <button type="submit"
                    class="w-full mt-2 rounded-xl bg-primary py-3 text-sm font-semibold text-primary-foreground shadow-md transition-all hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20 active:scale-[0.99]">
                    Зареєструватися
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-muted-foreground">
                Вже є акаунт?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Увійти</a>
            </div>
        </div>
    </div>
</main>
@endsection
