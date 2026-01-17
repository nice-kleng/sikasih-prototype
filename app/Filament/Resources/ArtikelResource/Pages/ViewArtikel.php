<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArtikel extends ViewRecord
{
    protected static string $resource = ArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('publish')
                ->label('Publish')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn() => $this->record->publish())
                ->visible(fn() => $this->record->status !== 'published'),

            Actions\Action::make('unpublish')
                ->label('Unpublish')
                ->icon('heroicon-o-x-circle')
                ->color('warning')
                ->requiresConfirmation()
                ->action(fn() => $this->record->unpublish())
                ->visible(fn() => $this->record->status === 'published'),

            Actions\Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn() => $this->record->archive())
                ->visible(fn() => $this->record->status !== 'archived'),

            Actions\EditAction::make(),

            Actions\DeleteAction::make(),
        ];
    }
}
