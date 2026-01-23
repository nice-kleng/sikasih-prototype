<?php

namespace App\Filament\Resources\DeteksiRisikoResource\Pages;

use App\Filament\Resources\DeteksiRisikoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDeteksiRisikos extends ListRecords
{
    protected static string $resource = DeteksiRisikoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Deteksi Risiko')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua')
                ->badge(fn() => $this->getModel()::count()),

            'risiko_rendah' => Tab::make('Risiko Rendah (KRR)')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'KRR (Kehamilan Risiko Rendah)'))
                ->badge(fn() => $this->getModel()::where('kategori', 'KRR (Kehamilan Risiko Rendah)')->count())
                ->badgeColor('success'),

            'risiko_tinggi' => Tab::make('Risiko Tinggi (KRT)')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'KRT (Kehamilan Risiko Tinggi)'))
                ->badge(fn() => $this->getModel()::where('kategori', 'KRT (Kehamilan Risiko Tinggi)')->count())
                ->badgeColor('warning'),

            'risiko_sangat_tinggi' => Tab::make('Risiko Sangat Tinggi (KRST)')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'KRST (Kehamilan Risiko Sangat Tinggi)'))
                ->badge(fn() => $this->getModel()::where('kategori', 'KRST (Kehamilan Risiko Sangat Tinggi)')->count())
                ->badgeColor('danger'),

            'bulan_ini' => Tab::make('Bulan Ini')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('waktu_deteksi', now()->month)
                    ->whereYear('waktu_deteksi', now()->year))
                ->badge(fn() => $this->getModel()::whereMonth('waktu_deteksi', now()->month)
                    ->whereYear('waktu_deteksi', now()->year)
                    ->count())
                ->badgeColor('info'),
        ];
    }
}
