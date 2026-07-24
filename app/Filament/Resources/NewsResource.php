<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $modelLabel = 'Новина';

    protected static ?string $pluralModelLabel = 'Новини';

    protected static string | \UnitEnum | null $navigationGroup = 'Контент';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Newspaper;

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

                        Forms\Components\Select::make('tag')
                            ->label('Тег')
                            ->options([
                                'Місто' => 'Місто',
                                'Транспорт' => 'Транспорт',
                                'Культура' => 'Культура',
                                'Події' => 'Події',
                                'Спорт' => 'Спорт',
                                'Спільнота' => 'Спільнота',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Короткий опис')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('date')
                            ->label('Дата')
                            ->required(),

                        Forms\Components\TextInput::make('read_time')
                            ->label('Час читання')
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Зображення')
                            ->image()
                            ->directory('news')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->label('Текст')
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

                Tables\Columns\TextColumn::make('tag')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('read_time')
                    ->label('Час читання')
                    ->sortable(),

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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
