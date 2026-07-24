# Filament Builder Agent

## Task

Create Filament 5.7 admin panel resources for each Eloquent model, providing full CRUD functionality with proper forms, tables, and navigation.

## Resources to Create

| Resource | Model | Icon | Navigation Group |
|----------|-------|------|-----------------|
| `NewsResource` | `News` | `heroicon-o-newspaper` | Контент |
| `EventResource` | `Event` | `heroicon-o-calendar-days` | Контент |
| `PlaceCategoryResource` | `PlaceCategory` | `heroicon-o-tag` | Місця |
| `PlaceResource` | `Place` | `heroicon-o-map-pin` | Місця |
| `LandmarkResource` | `Landmark` | `heroicon-o-building-library` | Місця |
| `TransportRouteResource` | `TransportRoute` | `heroicon-o-bus` | Транспорт |
| `ServiceGroupResource` | `ServiceGroup` | `heroicon-o-folder` | Послуги |
| `ServiceItemResource` | `ServiceItem` | `heroicon-o-document-text` | Послуги |
| `NavLinkResource` | `NavLink` | `heroicon-o-link` | Навігація |

## Form Builder Rules

Use Filament's Form API — never build custom HTML forms.

### NewsResource Form

```php
Forms\Components\Section::make('Основна інформація')
    ->schema([
        Forms\Components\TextInput::make('title')
            ->required()
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
        Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->maxLength(255),
        Forms\Components\Textarea::make('excerpt')
            ->rows(3)
            ->maxLength(500),
        Forms\Components\RichEditor::make('body')
            ->required()
            ->columnSpanFull(),
        Forms\Components\FileUpload::make('image')
            ->image()
            ->directory('news')
            ->maxSize(5120),
        Forms\Components\Select::make('category')
            ->options([
                'новини' => 'Новини',
                'оголошення' => 'Оголошення',
                'події' => 'Події',
            ])
            ->required(),
        Forms\Components\Toggle::make('is_published')
            ->default(true),
        Forms\Components\DateTimePicker::make('published_at'),
    ])
```

### PlaceResource Form

```php
Forms\Components\Section::make('Основна інформація')
    ->schema([
        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
        Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true),
        Forms\Components\Textarea::make('description')
            ->required()
            ->columnSpanFull(),
        Forms\Components\Select::make('category_id')
            ->relationship('category', 'name')
            ->required()
            ->searchable()
            ->preload(),
    ]),
Forms\Components\Section::make('Контакти та розташування')
    ->schema([
        Forms\Components\TextInput::make('address'),
        Forms\Components\TextInput::make('phone'),
        Forms\Components\TextInput::make('website')->url(),
        Forms\Components\TextInput::make('latitude')->numeric(),
        Forms\Components\TextInput::make('longitude')->numeric(),
    ]),
Forms\Components\Section::make('Медіа та налаштування')
    ->schema([
        Forms\Components\FileUpload::make('image')
            ->image()
            ->directory('places'),
        Forms\Components\Toggle::make('is_published')->default(true),
        Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
    ])
```

### EventResource Form

```php
Forms\Components\Section::make('Основна інформація')
    ->schema([
        Forms\Components\TextInput::make('title')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
        Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
        Forms\Components\Textarea::make('description')->required()->columnSpanFull(),
        Forms\Components\FileUpload::make('image')->image()->directory('events'),
    ]),
Forms\Components\Section::make('Деталі події')
    ->schema([
        Forms\Components\DateTimePicker::make('starts_at')->required(),
        Forms\Components\DateTimePicker::make('ends_at'),
        Forms\Components\TextInput::make('location'),
        Forms\Components\Toggle::make('is_free')->default(true),
        Forms\Components\TextInput::make('ticket_url')->url(),
        Forms\Components\Toggle::make('is_published')->default(true),
    ])
```

## Table Builder Rules

Use Filament's Table API for list views.

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image')
                ->circular()
                ->label('Зображення'),
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->limit(50),
            Tables\Columns\TextColumn::make('category.name')
                ->sortable(),
            Tables\Columns\IconColumn::make('is_published')
                ->boolean()
                ->label('Опубліковано'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d.m.Y')
                ->sortable()
                ->label('Створено'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('is_published')
                ->options([true => 'Опубліковано', false => 'Чернетка']),
            Tables\Filters\SelectFilter::make('category')
                ->options(fn ($model) => $model::pluck('category', 'category')->unique()),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('created_at', 'desc');
}
```

## Navigation Configuration

Each resource sets Ukrainian labels and grouped navigation:

```php
public static function getNavigationGroup(): ?string
{
    return 'Контент'; // or 'Місця', 'Транспорт', 'Послуги', 'Навігація'
}

public static function getNavigationLabel(): string
{
    return 'Новини'; // Ukrainian label
}

public static function getNavigationIcon(): ?string
{
    return 'heroicon-o-newspaper';
}

public static function getNavigationSort(): int
{
    return 1;
}
```

## Custom Pages

Create dashboard pages in `app/Filament/Pages/`:

- `Dashboard` — overview with widget grid (counts, recent items)
- `ContentOverview` — aggregated content stats

## Widgets

Create widgets in `app/Filament/Widgets/`:

- `StatsOverviewWidget` — total counts: news, events, places, landmarks
- `RecentNewsWidget` — last 5 published news items
- `UpcomingEventsWidget` — next 5 upcoming events
- `ContentStatusWidget` — published vs draft counts per content type

## Relationship Managers

- `PlaceResource` → `PlaceCategoryRelationshipManager` (manage category from place)
- `ServiceGroupResource` → `ServiceItemRelationshipManager` (manage items from group)

## Rules

- All labels and navigation text in **Ukrainian**
- Use Filament's built-in form/table API — no custom HTML forms
- Form fields match the model's `$fillable` attributes
- Use `relationship()` for foreign key selects
- Slugs auto-generated from title via `live(onBlur: true)` + `afterStateUpdated`
- File uploads use `->directory()` for organized storage
- Boolean toggles use `Toggle` component with `->boolean()` column
- Tables have search, sort, filters, and bulk actions
- Navigation icons use Heroicons

## Verification

```bash
php artisan filament:check
```

- `/admin` accessible and shows dashboard
- Each resource appears in navigation with correct group and icon
- CRUD operations work for every resource
- Forms validate required fields
- Tables show correct columns with sorting and search
- File uploads store to correct directories
- Relationship managers function correctly

## File Locations

```
app/Filament/Resources/NewsResource.php
app/Filament/Resources/EventResource.php
app/Filament/Resources/PlaceCategoryResource.php
app/Filament/Resources/PlaceResource.php
app/Filament/Resources/LandmarkResource.php
app/Filament/Resources/TransportRouteResource.php
app/Filament/Resources/ServiceGroupResource.php
app/Filament/Resources/ServiceItemResource.php
app/Filament/Resources/NavLinkResource.php
app/Filament/Resources/PlaceResource/Pages/
app/Filament/Resources/PlaceResource/RelationManagers/
app/Filament/Pages/Dashboard.php
app/Filament/Pages/ContentOverview.php
app/Filament/Widgets/StatsOverviewWidget.php
app/Filament/Widgets/RecentNewsWidget.php
app/Filament/Widgets/UpcomingEventsWidget.php
app/Filament/Widgets/ContentStatusWidget.php
```
