# Content Migrator Agent

## Task

Migrate all hardcoded content from `ContentService.php` arrays to a proper database-backed architecture using Eloquent models, migrations, and seeders.

## Target Models

Create one Eloquent model per content domain:

| Model | Table | Description |
|-------|-------|-------------|
| `News` | `news` | News articles and announcements |
| `Event` | `events` | City events, festivals, activities |
| `PlaceCategory` | `place_categories` | Categories for places (restaurants, parks, etc.) |
| `Place` | `places` | Points of interest, businesses, venues |
| `Landmark` | `landmarks` | Historical/cultural landmarks |
| `TransportRoute` | `transport_routes` | Public transport routes |
| `ServiceGroup` | `service_groups` | Groups of city services |
| `ServiceItem` | `service_items` | Individual service entries |
| `NavLink` | `nav_links` | Navigation menu items |

## Migration Rules

- Table names: `snake_case`, plural (e.g., `place_categories`)
- Primary keys: `$table->id()` (bigIncrements)
- Timestamps: `$table->timestamps()` on all tables
- Soft deletes: `$table->softDeletes()` where data may be archived
- Foreign keys: `$table->foreignId('model_id')->constrained()->onDelete('cascade')`
- Indexes: add on columns used in `where`, `orderBy`, `join`
- Use `nullable()` for optional columns — never default to empty string
- `down()` methods must fully reverse the migration

### Field Mapping Guide

**News:**
- `title` (string, required)
- `slug` (string, unique, indexed)
- `excerpt` (text, nullable)
- `body` (longText)
- `image` (string, nullable)
- `is_published` (boolean, default: false)
- `published_at` (timestamp, nullable)
- `category` (string, nullable) — "новини", "оголошення", etc.

**Event:**
- `title` (string, required)
- `slug` (string, unique, indexed)
- `description` (text)
- `image` (string, nullable)
- `location` (string, nullable)
- `starts_at` (timestamp)
- `ends_at` (timestamp, nullable)
- `is_free` (boolean, default: true)
- `ticket_url` (string, nullable)
- `is_published` (boolean, default: false)

**PlaceCategory:**
- `name` (string, required)
- `slug` (string, unique, indexed)
- `icon` (string, nullable)
- `description` (text, nullable)
- `sort_order` (integer, default: 0)

**Place:**
- `name` (string, required)
- `slug` (string, unique, indexed)
- `description` (text)
- `address` (string, nullable)
- `phone` (string, nullable)
- `website` (string, nullable)
- `image` (string, nullable)
- `latitude` (decimal, 10, 7, nullable)
- `longitude` (decimal, 10, 7, nullable)
- `working_hours` (json, nullable)
- `category_id` (foreignId → `place_categories`)
- `is_published` (boolean, default: false)
- `sort_order` (integer, default: 0)

**Landmark:**
- `name` (string, required)
- `slug` (string, unique, indexed)
- `description` (text)
- `address` (string, nullable)
- `image` (string, nullable)
- `latitude` (decimal, 10, 7, nullable)
- `longitude` (decimal, 10, 7, nullable)
- `year_built` (integer, nullable)
- `is_published` (boolean, default: false)

**TransportRoute:**
- `number` (string, required) — "route 1", "marshrutka 42"
- `type` (string) — "bus", "marshrutka", "tram", "trolleybus"
- `name` (string, required)
- `description` (text, nullable)
- `stops` (json) — ordered array of stop names
- `schedule` (json, nullable) — working hours, frequency
- `is_active` (boolean, default: true)

**ServiceGroup:**
- `name` (string, required)
- `slug` (string, unique, indexed)
- `icon` (string, nullable)
- `description` (text, nullable)
- `sort_order` (integer, default: 0)

**ServiceItem:**
- `name` (string, required)
- `description` (text, nullable)
- `phone` (string, nullable)
- `address` (string, nullable)
- `website` (string, nullable)
- `group_id` (foreignId → `service_groups`)

**NavLink:**
- `label` (string, required) — display text in Ukrainian
- `url` (string, required)
- `icon` (string, nullable)
- `target` (string, default: '_self')
- `sort_order` (integer, default: 0)
- `is_active` (boolean, default: true)
- `parent_id` (foreignId → `nav_links`, nullable) — for nested menus

## Seeder Rules

- Read existing data from `app/Services/ContentService.php` (or equivalent hardcoded arrays)
- Create seeders: `NewsSeeder`, `EventSeeder`, `PlaceCategorySeeder`, `PlaceSeeder`, `LandmarkSeeder`, `TransportRouteSeeder`, `ServiceGroupSeeder`, `ServiceItemSeeder`, `NavLinkSeeder`
- Use `DB::table()->insert()` or `Model::create()` — prefer `create()` for attribute casting
- Call all seeders from `DatabaseSeeder.php`
- Handle duplicate-safe inserts: `updateOrCreate()` or check `exists`

## Model Rules

- Use `$fillable` for mass-assignment protection
- Define relationships:
  - `Place` belongsTo `PlaceCategory`
  - `PlaceCategory` hasMany `Place`
  - `ServiceItem` belongsTo `ServiceGroup`
  - `ServiceGroup` hasMany `ServiceItem`
  - `NavLink` belongsTo `NavLink` (parent), hasMany `NavLink` (children)
- Add scopes: `scopePublished()`, `scopeActive()`, `scopeOrdered()`
- Use `Sluggable` trait or manual slug generation from title

## Verification

Run after completing all files:

```bash
php artisan migrate:fresh --seed
```

- All migrations run without errors
- All seeders complete
- `php artisan tinker` — verify each model has seeded records
- Verify counts match original hardcoded data

## File Locations

```
app/Models/News.php
app/Models/Event.php
app/Models/PlaceCategory.php
app/Models/Place.php
app/Models/Landmark.php
app/Models/TransportRoute.php
app/Models/ServiceGroup.php
app/Models/ServiceItem.php
app/Models/NavLink.php
database/migrations/xxxx_create_news_table.php
database/migrations/xxxx_create_events_table.php
database/migrations/xxxx_create_place_categories_table.php
database/migrations/xxxx_create_places_table.php
database/migrations/xxxx_create_landmarks_table.php
database/migrations/xxxx_create_transport_routes_table.php
database/migrations/xxxx_create_service_groups_table.php
database/migrations/xxxx_create_service_items_table.php
database/migrations/xxxx_create_nav_links_table.php
database/seeders/NewsSeeder.php
database/seeders/EventSeeder.php
database/seeders/PlaceCategorySeeder.php
database/seeders/PlaceSeeder.php
database/seeders/LandmarkSeeder.php
database/seeders/TransportRouteSeeder.php
database/seeders/ServiceGroupSeeder.php
database/seeders/ServiceItemSeeder.php
database/seeders/NavLinkSeeder.php
database/seeders/DatabaseSeeder.php
```
