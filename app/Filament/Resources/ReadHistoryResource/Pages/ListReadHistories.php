<?php

namespace App\Filament\Resources\ReadHistoryResource\Pages;

use App\Filament\Resources\ReadHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadHistories extends ListRecords
{
    protected static string $resource = ReadHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
