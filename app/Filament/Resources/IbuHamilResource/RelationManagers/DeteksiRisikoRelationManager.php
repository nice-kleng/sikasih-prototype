<?php

namespace App\Filament\Resources\IbuHamilResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeteksiRisikoRelationManager extends RelationManager
{
    protected static string $relationship = 'deteksiRisiko';

    protected static ?string $title = 'Riwayat Deteksi Risiko';

    protected static ?string $modelLabel = 'Deteksi Risiko';

    protected static ?string $pluralModelLabel = 'Riwayat Deteksi Risiko';

    protected static ?string $recordTitleAttribute = 'waktu_deteksi';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('waktu_deteksi')
            ->columns([
                Tables\Columns\TextColumn::make('waktu_deteksi')
                    ->label('Waktu Deteksi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_kehamilan')
                    ->label('Kehamilan Ke')
                    ->default('-')
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_persalinan')
                    ->label('Jumlah Persalinan')
                    ->default('-')
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_anak_hidup')
                    ->label('Anak Hidup')
                    ->default('-')
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('total_skor')
                    ->label('Total Skor')
                    ->badge()
                    ->color(fn(string $state): string => match (true) {
                        $state < 2 => 'success',
                        $state >= 2 && $state < 6 => 'warning',
                        $state >= 6 && $state < 12 => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori Risiko')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'KRR (Kehamilan Risiko Rendah)' => 'success',
                        'KRT (Kehamilan Risiko Tinggi)' => 'warning',
                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'KRR (Kehamilan Risiko Rendah)' => 'KRR',
                        'KRT (Kehamilan Risiko Tinggi)' => 'KRT',
                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'KRST',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('puskesmas.nama_puskesmas')
                    ->label('Puskesmas')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('waktu_deteksi', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori Risiko')
                    ->options([
                        'KRR (Kehamilan Risiko Rendah)' => 'KRR',
                        'KRT (Kehamilan Risiko Tinggi)' => 'KRT',
                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'KRST',
                    ])
                    ->multiple(),
                Tables\Filters\Filter::make('skor_tinggi')
                    ->label('Skor Tinggi (≥ 6)')
                    ->query(fn(Builder $query): Builder => $query->where('total_skor', '>=', 6))
                    ->toggle(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal')
                            ->native(false),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('waktu_deteksi', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('waktu_deteksi', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['dari_tanggal'] ?? null) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari_tanggal'])->format('d/m/Y');
                        }
                        if ($data['sampai_tanggal'] ?? null) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai_tanggal'])->format('d/m/Y');
                        }
                        return $indicators;
                    }),
            ])
            ->headerActions([
                // Bisa ditambahkan action create jika diperlukan
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Pemeriksaan Risiko Kehamilan')
                    ->modalWidth('5xl')
                    ->infolist([
                        Infolists\Components\Section::make('Informasi Deteksi')
                            ->schema([
                                Infolists\Components\TextEntry::make('waktu_deteksi')
                                    ->label('Waktu Deteksi')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-m-calendar'),
                                Infolists\Components\TextEntry::make('total_skor')
                                    ->label('Total Skor')
                                    ->badge()
                                    ->size('lg')
                                    ->color(fn(string $state): string => match (true) {
                                        $state < 2 => 'success',
                                        $state >= 2 && $state < 6 => 'warning',
                                        $state >= 6 && $state < 12 => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('kategori')
                                    ->label('Kategori Risiko')
                                    ->badge()
                                    ->size('lg')
                                    ->color(fn(string $state): string => match ($state) {
                                        'KRR (Kehamilan Risiko Rendah)' => 'success',
                                        'KRT (Kehamilan Risiko Tinggi)' => 'warning',
                                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'danger',
                                        default => 'gray',
                                    }),
                            ])
                            ->columns(3),

                        Infolists\Components\Section::make('Data Reproduksi')
                            ->schema([
                                Infolists\Components\TextEntry::make('dataReproduksi.usia_pertama_menikah')
                                    ->label('Usia Pertama Menikah')
                                    ->suffix(' tahun')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.usia_hamil_pertama')
                                    ->label('Usia Hamil Pertama')
                                    ->suffix(' tahun')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.jumlah_kehamilan')
                                    ->label('Jumlah Kehamilan')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.jumlah_persalinan')
                                    ->label('Jumlah Persalinan')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.jumlah_anak_hidup')
                                    ->label('Jumlah Anak Hidup')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.jumlah_keguguran')
                                    ->label('Jumlah Keguguran')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('dataReproduksi.riwayat_persalinan_sebelumnya')
                                    ->label('Riwayat Persalinan Sebelumnya')
                                    ->default('-')
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->collapsible(),

                        Infolists\Components\Section::make('Faktor Risiko Terdeteksi')
                            ->schema([
                                Infolists\Components\ViewEntry::make('faktor_risiko')
                                    ->label('')
                                    ->view('filament.infolists.entries.faktor-risiko-grid')
                                    ->viewData(fn($record) => [
                                        'record' => $record,
                                        'faktors' => [
                                            // Faktor 8 Poin (Merah - Bahaya)
                                            'danger' => [
                                                ['field' => 'perdarahan_dalam_kehamilan_ini', 'label' => 'Perdarahan Dalam Kehamilan', 'poin' => 8],
                                                ['field' => 'preeklampsia', 'label' => 'Preeklampsia / Hipertensi', 'poin' => 8],
                                                ['field' => 'hamil_kembar', 'label' => 'Hamil Kembar', 'poin' => 8],
                                                ['field' => 'hidramnion', 'label' => 'Hidramnion', 'poin' => 8],
                                                ['field' => 'bayi_mati_dalam_kandungan', 'label' => 'Bayi Mati Dalam Kandungan', 'poin' => 8],
                                                ['field' => 'kehamilan_lebih_bulan', 'label' => 'Kehamilan Lebih Bulan', 'poin' => 8],
                                                ['field' => 'letak_sungsang', 'label' => 'Letak Sungsang', 'poin' => 8],
                                                ['field' => 'letak_lintang', 'label' => 'Letak Lintang', 'poin' => 8],
                                                ['field' => 'eklampsia', 'label' => 'Eklampsia', 'poin' => 4],
                                            ],
                                            // Faktor 4 Poin (Kuning - Peringatan)
                                            'warning' => [
                                                ['field' => 'primigravida_terlalu_muda', 'label' => 'Primigravida Terlalu Muda (< 16 tahun)', 'poin' => 4],
                                                ['field' => 'primigravida_terlalu_tua', 'label' => 'Primigravida Terlalu Tua (> 35 tahun)', 'poin' => 4],
                                                ['field' => 'primigravida_tua_sekunder', 'label' => 'Primigravida Tua Sekunder', 'poin' => 4],
                                                ['field' => 'tinggi_badan_kurang_atau_sama_145', 'label' => 'Tinggi Badan ≤ 145 cm', 'poin' => 4],
                                                ['field' => 'pernah_gagal_kehamilan', 'label' => 'Pernah Gagal Kehamilan', 'poin' => 4],
                                                ['field' => 'pernah_vakum_atau_forceps', 'label' => 'Pernah Melahirkan dengan Vakum/Forceps', 'poin' => 4],
                                                ['field' => 'pernah_operasi_sesar', 'label' => 'Pernah Operasi Sesar', 'poin' => 4],
                                                ['field' => 'pernah_melahirkan_bblr', 'label' => 'Pernah Melahirkan BBLR', 'poin' => 4],
                                                ['field' => 'pernah_melahirkan_cacat_bawaan', 'label' => 'Pernah Melahirkan Bayi Cacat', 'poin' => 4],
                                                ['field' => 'anak_terkecil_kurang_2_tahun', 'label' => 'Anak Terkecil < 2 Tahun', 'poin' => 4],
                                                ['field' => 'riwayat_kelainan_obstetri_sebelumnya', 'label' => 'Riwayat Kelainan Obstetri', 'poin' => 4],
                                                ['field' => 'anemia_hb_kurang_11', 'label' => 'Anemia (HB < 11 g%)', 'poin' => 4],
                                                ['field' => 'riwayat_penyakit_kronis', 'label' => 'Riwayat Penyakit Kronis', 'poin' => 4],
                                            ],
                                        ],
                                    ]),
                            ])
                            ->collapsible()
                            ->collapsed(false),

                        Infolists\Components\Section::make('Rekomendasi')
                            ->schema([
                                Infolists\Components\TextEntry::make('rekomendasi')
                                    ->label('')
                                    ->listWithLineBreaks()
                                    ->bulleted()
                                    ->color('primary')
                                    ->icon('heroicon-m-light-bulb'),
                            ])
                            ->collapsed(false),

                        Infolists\Components\Section::make('Informasi Tambahan')
                            ->schema([
                                Infolists\Components\TextEntry::make('puskesmas.nama_puskesmas')
                                    ->label('Puskesmas')
                                    ->icon('heroicon-m-building-office-2'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Dicatat Pada')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-m-clock'),
                            ])
                            ->columns(2)
                            ->collapsed(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada riwayat deteksi risiko')
            ->emptyStateDescription('Riwayat deteksi risiko akan muncul di sini setelah dilakukan pemeriksaan.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession();
    }
}
