<?php

namespace App\Filament\Resources\PlaceCategoryResource\Pages;

use App\Filament\Resources\PlaceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceCategories extends ListRecords
{
    protected static string $resource = PlaceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
