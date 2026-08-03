<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactRequestResource\Pages;

use App\Filament\Resources\ContactRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactRequest extends CreateRecord
{
    protected static string $resource = ContactRequestResource::class;
}
