<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceGroupResource\Pages;
use App\Models\ServiceGroup;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class ServiceGroupResource extends Resource
{
    protected static ?string $model = ServiceGroup::class;

    protected static ?string $modelLabel = 'Група послуг';

    protected static ?string $pluralModelLabel = 'Групи послуг';

    protected static string | \UnitEnum | null $navigationGroup = 'Послуги';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Cog;

    protected static ?string $recordTitleAttribute = 'category';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('category')
                            ->label('Категорія')
                            ->required(),

                        Forms\Components\TextInput::make('position')
                            ->label('Позиція')
                            ->required()
                            ->numeric(),

                        Forms\Components\Repeater::make('items')
                            ->label('Елементи')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('icon')
                                    ->label('Іконка')
                                    ->required(),

                                Forms\Components\TextInput::make('title')
                                    ->label('Заголовок')
                                    ->required(),

                                Forms\Components\TextInput::make('description')
                                    ->label('Опис')
                                    ->required(),

                                Forms\Components\TextInput::make('action')
                                    ->label('Дія')
                                    ->required(),

                                Forms\Components\TextInput::make('position')
                                    ->label('Позиція')
                                    ->required()
                                    ->numeric(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Елементів')
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
            'index' => Pages\ListServiceGroups::route('/'),
            'create' => Pages\CreateServiceGroup::route('/create'),
            'edit' => Pages\EditServiceGroup::route('/{record}/edit'),
        ];
    }
}
