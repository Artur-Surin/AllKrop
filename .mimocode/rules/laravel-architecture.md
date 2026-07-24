# Laravel Architecture

## Controllers

- Controllers handle HTTP only: accept request, call service, return response
- Never write business logic in controllers — delegate to service classes
- Use dependency injection via constructor parameters for services
- Return `View` for pages, `JsonResource` for API, `RedirectResponse` for mutations
- Use `FormRequest` classes for validation, not inline `$request->validate()`

## Services

- Services contain business logic, data transformation, and orchestration
- Place in `app/Services/`, named as `{Domain}Service` (e.g., `NewsService`)
- Services are plain PHP classes — no HTTP concerns
- Use dependency injection for services; bind interfaces in `AppServiceProvider` when needed
- Return Eloquent models, collections, or value objects — never raw arrays for complex data

## Models

- Define all relationships (`hasOne`, `hasMany`, `belongsTo`, `belongsToMany`, etc.)
- Use scopes for reusable query constraints (e.g., `scopePublished`, `scopeActive`)
- Define accessors and mutators for computed or transformed attributes
- Use `$fillable` or `$guarded` — never leave mass-assignment protection off
- Keep casts up to date for date, enum, and encrypted attributes
- No business logic, HTTP handling, or view rendering in models

## Migrations

- Every migration must have a working `down()` method
- Use foreign key constraints with `constrained()` and `onDelete('cascade')` or `onDelete('set null')`
- Add indexes on columns used in `where`, `orderBy`, and `join` clauses
- Use `nullable()` for optional columns; avoid default empty strings
- Use `$table->id()` (bigIncrements) for primary keys
- Timestamps (`created_at`, `updated_at`) via `$table->timestamps()` unless truly unnecessary

## Routes

- Use `Route::resource()` for CRUD endpoints
- Always name routes: `Route::resource('places', PlaceController::class)->names('places')`
- Group related routes with `Route::middleware()->prefix()->name()->group()`
- Use route model binding: `Route::get('/places/{place}', ...)`
- Define admin routes under a `filament` or `admin` prefix with `auth` middleware

## Views / Blade

- Views contain presentation logic only
- Use `@props` to declare typed, expected data in components
- Use `@error` for inline validation messages, not `@if ($errors->any())`
- No `@php` blocks with multi-line logic; extract to helpers or components
- Use `@dd()` or `@dump()` only during development, never in production views
- Use `{{ }}` for escaped output, `{!! !!}` only with trusted HTML

## Filament

- One Filament Resource per Eloquent Model
- Place resources in `app/Filament/Resources/{Model}Resource.php`
- Use Filament's Form Builder and Table Builder — avoid custom form HTML
- Custom dashboard pages go in `app/Filament/Pages/`
- Widgets for stats/metrics go in `app/Filament/Widgets/`
- Use relationship managers for related-model editing within parent forms
- Navigation: set `getNavigationGroup()`, `getNavigationIcon()`, `getNavigationLabel()`

## Directory Structure

```
app/
├── Filament/
│   ├── Pages/          # Custom admin pages
│   ├── Resources/      # CRUD resources (one per model)
│   └── Widgets/        # Dashboard widgets
├── Http/
│   ├── Controllers/    # Thin controllers
│   └── Requests/       # Form Request classes
├── Models/             # Eloquent models
├── Services/           # Business logic
├── View/               # View composers, components
└── Providers/          # Service providers
database/
├── migrations/         # Schema migrations
└── seeders/            # Database seeders
resources/
└── views/
    ├── components/     # Anonymous Blade components
    ├── layouts/        # Master layouts
    └── pages/          # Page-specific views
```
