<?php

namespace App\Filament\Resources\BookReadResource\Pages;

use App\Filament\Resources\BookReadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookRead extends EditRecord
{
    protected static string $resource = BookReadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
