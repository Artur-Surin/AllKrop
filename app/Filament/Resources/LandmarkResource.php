<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LandmarkResource\Pages;
use App\Models\Landmark;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class LandmarkResource extends Resource
{
    protected static ?string $model = Landmark::class;

    protected static ?string $modelLabel = "Пам'ятка";

    protected static ?string $pluralModelLabel = "Пам'ятки";

    protected static string | \UnitEnum | null $navigationGroup = 'Контент';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::BuildingLibrary;

    protected static ?string $recordTitleAttribute = 'title';

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
                            ->directory('landmarks')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('description')
                            ->label('Короткий опис')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->label('Текст')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListLandmarks::route('/'),
            'create' => Pages\CreateLandmark::route('/create'),
            'edit' => Pages\EditLandmark::route('/{record}/edit'),
        ];
    }
}
