<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $modelLabel = 'Заклад';

    protected static ?string $pluralModelLabel = 'Заклади';

    protected static string | \UnitEnum | null $navigationGroup = 'Заклади';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::MapPin;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make()
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
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
