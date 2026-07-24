<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TransportRouteResource\Pages;
use App\Models\TransportRoute;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class TransportRouteResource extends Resource
{
    protected static ?string $model = TransportRoute::class;

    protected static ?string $modelLabel = 'Маршрут';

    protected static ?string $pluralModelLabel = 'Маршрути';

    protected static string | \UnitEnum | null $navigationGroup = 'Транспорт';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Truck;

    protected static ?string $recordTitleAttribute = 'number';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Номер')
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('Тип')
                            ->options([
                                'Тролейбус' => 'Тролейбус',
                                'Електробус' => 'Електробус',
                                'Автобус' => 'Автобус',
                                'Маршрутка' => 'Маршрутка',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('route_from')
                            ->label('Від')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('route_to')
                            ->label('До')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('interval')
                            ->label('Інтервал')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('route_from')
                    ->label('Від')
                    ->searchable(),

                Tables\Columns\TextColumn::make('route_to')
                    ->label('До')
                    ->searchable(),

                Tables\Columns\TextColumn::make('interval')
                    ->label('Інтервал'),

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
            'index' => Pages\ListTransportRoutes::route('/'),
            'create' => Pages\CreateTransportRoute::route('/create'),
            'edit' => Pages\EditTransportRoute::route('/{record}/edit'),
        ];
    }
}
