<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $modelLabel = 'Подія';

    protected static ?string $pluralModelLabel = 'Події';

    protected static string | \UnitEnum | null $navigationGroup = 'Контент';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Calendar;

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
                            ->directory('events')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('category')
                            ->label('Категорія')
                            ->options([
                                'Концерт' => 'Концерт',
                                'Ярмарок' => 'Ярмарок',
                                'Театр' => 'Театр',
                                'Кіно' => 'Кіно',
                                'Виставка' => 'Виставка',
                                'Родина' => 'Родина',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('date')
                            ->label('Дата')
                            ->required(),

                        Forms\Components\TextInput::make('time')
                            ->label('Час')
                            ->required(),

                        Forms\Components\TextInput::make('place')
                            ->label('Місце')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->label('Ціна')
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

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('time'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
