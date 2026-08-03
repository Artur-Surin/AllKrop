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
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Зображення')
                    ->image()
                    ->directory('places')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('name')
                    ->label('Назва')
                    ->required()
                    ->columnSpanFull(),

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

                Forms\Components\TextInput::make('hours')
                    ->label('Години роботи')
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->required(),

                Forms\Components\RichEditor::make('description')
                    ->label('Опис')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            if (! isset($state['type'])) {
                                return implode('', array_map(function ($p) {
                                    $p = trim((string) $p);
                                    if ($p === '') {
                                        return '';
                                    }

                                    return str_starts_with($p, '<') ? $p : "<p>{$p}</p>";
                                }, $state));
                            }
                        }

                        return $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if (empty($state)) {
                            return [];
                        }
                        if (is_string($state)) {
                            preg_match_all('/<p>(.*?)<\/p>/is', $state, $matches);
                            if (! empty($matches[1])) {
                                $paragraphs = array_map(fn ($p) => trim(strip_tags($p)), $matches[1]);

                                return array_values(array_filter($paragraphs, fn ($p) => $p !== ''));
                            }
                            $lines = array_map('trim', explode("\n", strip_tags($state)));

                            return array_values(array_filter($lines, fn ($l) => $l !== ''));
                        }

                        return $state;
                    })
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.label')
                    ->label('Категорія')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->sortable(),

                Tables\Columns\TextColumn::make('area')
                    ->label('Район')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
