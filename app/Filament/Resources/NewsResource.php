<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $modelLabel = 'Новина';

    protected static ?string $pluralModelLabel = 'Новини';

    protected static string|\UnitEnum|null $navigationGroup = 'Контент';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Newspaper;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Основна інформація')
                    ->description('Заголовок, тег та короткий опис')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->dehydrated()
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
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
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Короткий опис')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Зображення')
                    ->description('Головне зображення новини')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Зображення')
                            ->image()
                            ->disk('public')
                            ->directory('news')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Текст')
                    ->description('Повний текст новини')
                    ->schema([
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
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'ul',
                                'ol',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Налаштування')
                    ->description('Дата, джерело та публікація')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date')
                            ->label('Дата публікації')
                            ->required()
                            ->default(now())
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('read_time')
                            ->label('Час читання')
                            ->placeholder('напр. 5 хв')
                            ->columnSpan(1),

                        Forms\Components\Select::make('source')
                            ->label('Джерело')
                            ->options([
                                'Ручне' => 'Ручне',
                                'RSS' => 'RSS',
                            ])
                            ->default('Ручне')
                            ->live()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('source_url')
                            ->label('URL джерела')
                            ->url()
                            ->visible(fn (Forms\Get $get) => $get('source') === 'RSS')
                            ->dehydrated(fn ($state) => ! empty($state))
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Опубліковано')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Зображення')
                    ->disk('public')
                    ->circular()
                    ->grow(false),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('tag')
                    ->label('Тег')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Місто' => 'gray',
                        'Транспорт' => 'info',
                        'Культура' => 'warning',
                        'Події' => 'success',
                        'Спорт' => 'danger',
                        'Спільнота' => 'primary',
                    }),

                Tables\Columns\TextColumn::make('source')
                    ->label('Джерело')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'RSS' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
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
            ->filters([
                Tables\Filters\SelectFilter::make('tag')
                    ->label('Тег')
                    ->options([
                        'Місто' => 'Місто',
                        'Транспорт' => 'Транспорт',
                        'Культура' => 'Культура',
                        'Події' => 'Події',
                        'Спорт' => 'Спорт',
                        'Спільнота' => 'Спільнота',
                    ]),

                Tables\Filters\SelectFilter::make('source')
                    ->label('Джерело')
                    ->options([
                        'Ручне' => 'Ручне',
                        'RSS' => 'RSS',
                    ]),

                Tables\Filters\SelectFilter::make('is_published')
                    ->label('Статус')
                    ->options([
                        1 => 'Опубліковано',
                        0 => 'Чернетка',
                    ]),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
