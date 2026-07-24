<?php

declare(strict_types=1);

namespace App\Filament\Resources\PlaceCategoryResource\Pages;

use App\Filament\Resources\PlaceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaceCategory extends EditRecord
{
    protected static string $resource = PlaceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
