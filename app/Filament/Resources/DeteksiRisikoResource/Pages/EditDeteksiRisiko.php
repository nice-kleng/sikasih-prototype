<?php

namespace App\Filament\Resources\DeteksiRisikoResource\Pages;

use App\Filament\Resources\DeteksiRisikoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeteksiRisiko extends EditRecord
{
    protected static string $resource = DeteksiRisikoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
