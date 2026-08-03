<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $modelLabel = 'Заклад';

    protected static ?string $pluralModelLabel = 'Заклади';

    protected static string|\UnitEnum|null $navigationGroup = 'Заклади';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug((string) $state)))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Головне зображення')
                    ->image()
                    ->disk('public')
                    ->directory('places')
                    ->visibility('public')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('gallery')
                    ->label('Галерея фотографій')
                    ->helperText('Завантажте кілька фото закладу. Можна перетягувати для зміни порядку.')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('places/gallery')
                    ->visibility('public')
                    ->maxFiles(20)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_published')
                    ->label('Опубліковано')
                    ->default(true),

                Forms\Components\Select::make('category_id')
                    ->label('Категорія')
                    ->relationship('category', 'label')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('rating')
                    ->label('Рейтинг')
                    ->required(),

                Forms\Components\TextInput::make('area')
                    ->label('Район')
                    ->required(),

                Forms\Components\TextInput::make('address')
                    ->label('Адреса')
                    ->required(),

                Forms\Components\Textarea::make('hours')
                    ->label('Години роботи')
                    ->rows(4)
                    ->helperText('Приклад: "11:00 - 22:00" або кожен день з нового рядка (наприклад: пн-сб: 11:00 - 22:00 \n нд: Закрито)')
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Опис (кожен абзац — окремий рядок)')
                    ->helperText('Кожен рядок тексту збережеться як окремий абзац на сайті')
                    ->rows(8)
                    ->formatStateUsing(function ($state): string {
                        if (is_array($state)) {
                            return implode("\n", $state);
                        }

                        return (string) ($state ?? '');
                    })
                    ->dehydrateStateUsing(function ($state): array {
                        if (empty($state)) {
                            return [];
                        }

                        $lines = array_map('trim', explode("\n", (string) $state));

                        return array_values(array_filter($lines, fn (string $l): bool => $l !== ''));
                    })
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('features')
                    ->label('Послуги та характеристики')
                    ->helperText('Додайте групи послуг (наприклад: Кухня, Зал, Розваги) та їхні пункти')
                    ->schema([
                        Forms\Components\TextInput::make('group')
                            ->label('Назва групи')
                            ->required()
                            ->placeholder('Наприклад: Кухня'),

                        Forms\Components\TagsInput::make('items')
                            ->label('Пункти')
                            ->placeholder('Введіть пункт та натисніть Enter')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->addActionLabel('Додати групу послуг')
                    ->collapsible()
                    ->cloneable()
                    ->defaultItems(0)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.label')
                    ->label('Категорія')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Категорія')
                    ->relationship('category', 'label'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Статус публікації'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
