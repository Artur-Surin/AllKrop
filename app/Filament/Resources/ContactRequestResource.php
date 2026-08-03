<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactRequestResource\Pages;
use App\Models\ContactRequest;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::Envelope;

    protected static string|\UnitEnum|null $navigationGroup = 'Зворотний зв\'язок';

    protected static ?string $modelLabel = 'Звернення';

    protected static ?string $pluralModelLabel = 'Звернення';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label("Ім'я")
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(150),
            Forms\Components\Select::make('subject')
                ->label('Тема звернення')
                ->options(ContactRequest::SUBJECTS)
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Статус')
                ->options(ContactRequest::STATUSES)
                ->required(),
            Forms\Components\Textarea::make('message')
                ->label('Повідомлення')
                ->rows(5)
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('ip_address')
                ->label('IP адреса')
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Тема')
                    ->formatStateUsing(fn ($state) => ContactRequest::SUBJECTS[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ads' => 'warning',
                        'news' => 'info',
                        'place' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->formatStateUsing(fn ($state) => ContactRequest::STATUSES[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата надходження')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(ContactRequest::STATUSES),
                Tables\Filters\SelectFilter::make('subject')
                    ->label('Тема')
                    ->options(ContactRequest::SUBJECTS),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('mark_resolved')
                    ->label('Опрацьовано')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ContactRequest $record) => $record->status !== 'resolved')
                    ->action(fn (ContactRequest $record) => $record->update(['status' => 'resolved'])),
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
            'index' => Pages\ListContactRequests::route('/'),
            'create' => Pages\CreateContactRequest::route('/create'),
            'edit' => Pages\EditContactRequest::route('/{record}/edit'),
        ];
    }
}
