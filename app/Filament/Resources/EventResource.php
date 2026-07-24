<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

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
                Forms\Components\Section::make('Основна інформація')
                    ->description('Заголовок та категорія')
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

                        Forms\Components\Select::make('category')
                            ->label('Категорія')
                            ->options([
                                'Концерт' => 'Концерт',
                                'Ярмарок' => 'Ярмарок',
                                'Театр' => 'Театр',
                                'Кіно' => 'Кіно',
                                'Виставка' => 'Виставка',
                                'Родина' => 'Родина',
                                'Спорт' => 'Спорт',
                                'Освіта' => 'Освіта',
                            ])
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Дата та час')
                    ->description('Коли відбувається подія')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Дата')
                            ->required()
                            ->default(now())
                            ->columnSpan(1),

                        Forms\Components\TimePicker::make('time')
                            ->label('Час')
                            ->required()
                            ->seconds(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Місце проведення')
                    ->description('Де та за скільки')
                    ->schema([
                        Forms\Components\TextInput::make('place')
                            ->label('Місце')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('price')
                            ->label('Ціна')
                            ->placeholder('напр. Безкоштовно або 150 грн')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Зображення')
                    ->description('Головне зображення події')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Зображення')
                            ->image()
                            ->directory('events')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Опис')
                    ->description('Детальний опис події')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Опис')
                            ->formatStateUsing(function ($state) {
                                if (is_array($state)) {
                                    if (! isset($state['type'])) {
                                        return implode('', array_map(function ($p) {
                                            $p = trim((string) $p);
                                            if ($p === '') return '';
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
                    ->description('Джерело та публікація')
                    ->schema([
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
                            ->dehydrated(fn ($state) => !empty($state))
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

                Tables\Columns\TextColumn::make('category')
                    ->label('Категорія')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Концерт' => 'info',
                        'Ярмарок' => 'warning',
                        'Театр' => 'primary',
                        'Кіно' => 'success',
                        'Виставка' => 'gray',
                        'Родина' => 'danger',
                        'Спорт' => 'danger',
                        'Освіта' => 'info',
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

                Tables\Columns\TextColumn::make('time')
                    ->label('Час'),

                Tables\Columns\TextColumn::make('place')
                    ->label('Місце')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категорія')
                    ->options([
                        'Концерт' => 'Концерт',
                        'Ярмарок' => 'Ярмарок',
                        'Театр' => 'Театр',
                        'Кіно' => 'Кіно',
                        'Виставка' => 'Виставка',
                        'Родина' => 'Родина',
                        'Спорт' => 'Спорт',
                        'Освіта' => 'Освіта',
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

                Tables\Filters\Filter::make('date')
                    ->label('Дата події')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Від')
                            ->native(false),
                        Forms\Components\DatePicker::make('date_until')
                            ->label('До')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date_from'], fn ($query, $date) => $query->where('date', '>=', $date))
                            ->when($data['date_until'], fn ($query, $date) => $query->where('date', '<=', $date));
                    }),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
