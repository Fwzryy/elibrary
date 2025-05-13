<?php

namespace App\Filament\Resources\BookReadResource\Pages;

use App\Filament\Resources\BookReadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookReads extends ListRecords
{
    protected static string $resource = BookReadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
