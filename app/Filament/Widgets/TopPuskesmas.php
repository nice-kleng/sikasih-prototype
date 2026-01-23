<?php

namespace App\Filament\Widgets;

use App\Models\Puskesmas;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class TopPuskesmas extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $user = Auth::user();
        return $table
            ->heading('Top 10 Puskesmas - Pemeriksaan ANC Bulan Ini')
            ->query(
                Puskesmas::query()
                    ->withCount([
                        'deteksiRisiko' => function ($query) {
                            $query->whereMonth('waktu_deteksi', now()->month)
                                ->whereYear('waktu_deteksi', now()->year);
                        }
                    ])
                    ->withCount(['ibuHamil'])
                    ->orderBy('deteksi_risiko_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('row_number')
                    ->label('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama_puskesmas')
                    ->label('Nama Puskesmas')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->label('Kabupaten')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'poned',
                        'gray' => 'non_poned',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                Tables\Columns\TextColumn::make('ibu_hamil_count')
                    ->label('Ibu Hamil Aktif')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deteksi_risiko_count')
                    ->label('Deteksi Risiko Bulan Ini')
                    ->alignCenter()
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
            ])
            ->defaultSort('deteksi_risiko_count', 'desc');
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user->hasRole('super_admin');
    }
}
