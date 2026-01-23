<?php

namespace App\Filament\Widgets;

use App\Models\DeteksiRisiko;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentActivities extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Activities')
            ->query(
                DeteksiRisiko::query()
                    ->when(Auth::user()->hasRole('puskesmas'), function ($query) {
                        $query->where('puskesmas_id', Auth::user()->puskesmas->id);
                    })
                    ->with(['ibuHamil', 'puskesmas'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('ibuHamil.nama_lengkap')
                    ->label('Nama Ibu')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('puskesmas.nama_puskesmas')
                    ->label('Puskesmas')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('kategori')
                    ->label('Kategori Risiko')
                    ->sortable(),
                TextColumn::make('total_skor')
                    ->label('Total Skor')
                    ->sortable(),
            ])
            ->defaultSort('waktu_deteksi', 'desc')
            ->paginated([5]);
    }
}
