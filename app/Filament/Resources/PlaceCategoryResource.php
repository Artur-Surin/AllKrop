<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceCategoryResource\Pages;
use App\Models\PlaceCategory;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class PlaceCategoryResource extends Resource
{
    protected static ?string $model = PlaceCategory::class;

    protected static ?string $modelLabel = 'Категорія';

    protected static ?string $pluralModelLabel = 'Категорії';

    protected static string | \UnitEnum | null $navigationGroup = 'Заклади';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::FolderOpen;

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Ключ')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('label')
                            ->label('Назва')
                            ->required(),

                        Forms\Components\Select::make('icon')
                            ->label('Іконка')
                            ->options([
                                'UtensilsCrossed' => 'UtensilsCrossed',
                                'ShoppingBag' => 'ShoppingBag',
                                'Drama' => 'Drama',
                                'HeartPulse' => 'HeartPulse',
                                'GraduationCap' => 'GraduationCap',
                                'Car' => 'Car',
                                'Briefcase' => 'Briefcase',
                                'Factory' => 'Factory',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('description')
                            ->label('Опис')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('icon')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPlaceCategories::route('/'),
            'create' => Pages\CreatePlaceCategory::route('/create'),
            'edit' => Pages\EditPlaceCategory::route('/{record}/edit'),
        ];
    }
}
