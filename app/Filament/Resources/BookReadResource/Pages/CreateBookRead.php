<?php

namespace App\Filament\Resources\BookReadResource\Pages;

use App\Filament\Resources\BookReadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookRead extends CreateRecord
{
    protected static string $resource = BookReadResource::class;
}
