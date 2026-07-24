# Coding Standards

## PHP

- Follow PSR-12 coding style
- Always declare `declare(strict_types=1);` at the top of every PHP file
- Use typed properties on classes — never leave properties untyped
- No wildcard imports (`use SomeLib\*`); import each class/interface individually
- Prefer enums over constants for bounded sets of values
- Use `readonly` properties and `enum` backed types where appropriate

## Laravel

- Controllers stay thin: handle HTTP concerns only, delegate business logic to Services
- Define Eloquent relationships on models, never join manually in controllers
- Use Form Requests for validation — never validate in controllers or routes
- Use API Resources for all JSON responses, even single-model endpoints
- Use Route Model Binding whenever a route receives a single model
- Prefer `Route::resource()` and named routes over manual `Route::get/post` pairs

## Blade

- Use `@extends` / `@section` pattern for page layouts
- Use anonymous components (`components/*.blade.php`) for reusable UI pieces
- Pass typed data to components via `@props` with explicit type hints
- No business logic in views — format data in controllers, Services, or ViewModels
- No `@php` blocks with multi-line logic; extract to helpers or components
- Use `@csrf`, `@method` on all forms

## CSS / Tailwind

- Use `oklch` color space for the theme system
- Define design tokens as CSS custom properties on `:root` / `@theme`
- Follow BEM naming for any custom utility classes outside Tailwind
- No inline `style` attributes — use utility classes exclusively
- Use `@apply` sparingly; prefer composing utilities directly in markup

## JavaScript

- ES6+ syntax: `const`/`let`, arrow functions, template literals, `fetch`
- Vanilla JS only — no jQuery, no frontend framework
- Use event delegation on container elements rather than per-item listeners
- Keep JS unobtrusive: attach behavior in `alpine:init` or `DOMContentLoaded`
- No inline `onclick` handlers in Blade; use `x-on:click` or vanilla listeners

## Naming Conventions

| Context         | Convention    | Example                              |
|-----------------|---------------|--------------------------------------|
| PHP files       | snake_case    | `PlaceController.php`               |
| PHP functions   | snake_case    | `get_active_news()`                 |
| PHP classes     | PascalCase    | `PlaceService`                       |
| Blade files     | kebab-case    | `place-card.blade.php`              |
| CSS files       | kebab-case    | `hero-section.css`                  |
| JS files        | kebab-case    | `filter-controls.js`                |
| Database tables | snake_case    | `place_categories`                   |
| Routes          | dot notation  | `places.index`, `places.show`       |

## File Organization

- One class per file; filename matches the class name
- One Blade component per file in `resources/views/components/`
- Group files by domain feature when practical (e.g., `News/`, `Places/`)
- Keep config values in `.env` — never hardcode secrets or environment-specific values

## Comments

- Write comments only to explain **why** something exists, not **what** it does
- No docblocks on obvious methods — the method name and types tell the story
- Use inline comments for workarounds, non-obvious constraints, or business rules
- Never leave `TODO` comments without a linked issue or ticket
