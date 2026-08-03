<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::ChatBubbleLeftEllipsis;

    protected static string|\UnitEnum|null $navigationGroup = 'Заклади';

    protected static ?string $modelLabel = 'Відгук';

    protected static ?string $pluralModelLabel = 'Відгуки';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('place_id')
                ->label('Заклад')
                ->relationship('place', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('name')
                ->label("Ім'я")
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('rating')
                ->label('Оцінка')
                ->options([
                    1 => '1 ⭐',
                    2 => '2 ⭐⭐',
                    3 => '3 ⭐⭐⭐',
                    4 => '4 ⭐⭐⭐⭐',
                    5 => '5 ⭐⭐⭐⭐⭐',
                ])
                ->required(),
            Forms\Components\Textarea::make('comment')
                ->label('Коментар')
                ->rows(4)
                ->required(),
            Forms\Components\Toggle::make('is_approved')
                ->label('Схвалено')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('place.name')
                    ->label('Заклад')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Оцінка')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Коментар')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Схвалено')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_approved')
                    ->label('Статус')
                    ->options([
                        true => 'Схвалено',
                        false => 'Очікує',
                    ]),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Оцінка')
                    ->options([
                        1 => '1 ⭐',
                        2 => '2 ⭐⭐',
                        3 => '3 ⭐⭐⭐',
                        4 => '4 ⭐⭐⭐⭐',
                        5 => '5 ⭐⭐⭐⭐⭐',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
                Actions\Action::make('approve')
                    ->label('Схвалити')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['is_approved' => true])),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
