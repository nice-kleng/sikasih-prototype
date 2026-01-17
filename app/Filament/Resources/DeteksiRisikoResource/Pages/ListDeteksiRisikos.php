<?php

namespace App\Filament\Resources\DeteksiRisikoResource\Pages;

use App\Filament\Resources\DeteksiRisikoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeteksiRisikos extends ListRecords
{
    protected static string $resource = DeteksiRisikoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
