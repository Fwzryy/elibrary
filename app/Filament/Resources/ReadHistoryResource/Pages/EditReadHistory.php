<?php

namespace App\Filament\Resources\ReadHistoryResource\Pages;

use App\Filament\Resources\ReadHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReadHistory extends EditRecord
{
    protected static string $resource = ReadHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
