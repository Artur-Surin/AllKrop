<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LandmarkResource\Pages;
use App\Models\Landmark;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class LandmarkResource extends Resource
{
    protected static ?string $model = Landmark::class;

    protected static ?string $modelLabel = "Пам'ятка";

    protected static ?string $pluralModelLabel = "Пам'ятки";

    protected static string|\UnitEnum|null $navigationGroup = 'Контент';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

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
