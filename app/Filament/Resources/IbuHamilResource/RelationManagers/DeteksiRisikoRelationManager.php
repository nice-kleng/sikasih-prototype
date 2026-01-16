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

    protected static ?string $recordTitleAttribute = 'waktu_deteksi';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('waktu_deteksi')
            ->columns([
                Tables\Columns\TextColumn::make('waktu_deteksi')
                    ->label('Waktu Deteksi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_kehamilan')
                    ->label('Kehamilan Ke')
                    ->default('-'),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_persalinan')
                    ->label('Jumlah Persalinan')
                    ->default('-'),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_anak_hidup')
                    ->label('Anak Hidup')
                    ->default('-'),

                Tables\Columns\TextColumn::make('total_skor')
                    ->label('Total Skor')
                    ->badge()
                    ->color(fn(string $state): string => match (true) {
                        $state < 2 => 'success',
                        $state >= 2 && $state < 6 => 'warning',
                        $state >= 6 && $state < 12 => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori Risiko')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'KRR (Kehamilan Risiko Rendah)' => 'success',
                        'KRT (Kehamilan Risiko Tinggi)' => 'warning',
                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('waktu_deteksi', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori Risiko')
                    ->options([
                        'KRR (Kehamilan Risiko Rendah)' => 'KRR',
                        'KRT (Kehamilan Risiko Tinggi)' => 'KRT',
                        'KRST (Kehamilan Risiko Sangat Tinggi)' => 'KRST',
                    ]),
            ])
            ->headerActions([
                // Bisa ditambahkan action create jika diperlukan
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->modalHeading('Detail Pemeriksaan Risiko Kehamilan')
                    ->modalWidth('5xl')
                    ->infolist([
                        Infolists\Components\Section::make('Informasi Deteksi')
                            ->schema([
                                Infolists\Components\TextEntry::make('waktu_deteksi')
                                    ->label('Waktu Deteksi')
                                    ->dateTime('d/m/Y H:i'),
                                Infolists\Components\TextEntry::make('total_skor')
                                    ->label('Total Skor')
                                    ->badge()
                                    ->color(fn(string $state): string => match (true) {
                                        $state < 2 => 'success',
                                        $state >= 2 && $state < 6 => 'warning',
                                        $state >= 6 && $state < 12 => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('kategori')
                                    ->label('Kategori Risiko')
                                    ->badge()
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
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        // Faktor Risiko 4 Poin
                                        Infolists\Components\TextEntry::make('eklampsia')
                                            ->label('Eklampsia')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->eklampsia),

                                        // Faktor Risiko 8 Poin
                                        Infolists\Components\TextEntry::make('perdarahan_dalam_kehamilan_ini')
                                            ->label('Perdarahan Dalam Kehamilan')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->perdarahan_dalam_kehamilan_ini),

                                        Infolists\Components\TextEntry::make('preeklampsia')
                                            ->label('Preeklampsia / Hipertensi')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->preeklampsia),

                                        Infolists\Components\TextEntry::make('hamil_kembar')
                                            ->label('Hamil Kembar')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->hamil_kembar),

                                        Infolists\Components\TextEntry::make('hidramnion')
                                            ->label('Hidramnion')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->hidramnion),

                                        Infolists\Components\TextEntry::make('bayi_mati_dalam_kandungan')
                                            ->label('Bayi Mati Dalam Kandungan')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->bayi_mati_dalam_kandungan),

                                        Infolists\Components\TextEntry::make('kehamilan_lebih_bulan')
                                            ->label('Kehamilan Lebih Bulan')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->kehamilan_lebih_bulan),

                                        Infolists\Components\TextEntry::make('letak_sungsang')
                                            ->label('Letak Sungsang')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->letak_sungsang),

                                        Infolists\Components\TextEntry::make('letak_lintang')
                                            ->label('Letak Lintang')
                                            ->badge()
                                            ->color('danger')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (8 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->letak_lintang),

                                        // Faktor Risiko 4 Poin
                                        Infolists\Components\TextEntry::make('primigravida_terlalu_muda')
                                            ->label('Primigravida Terlalu Muda (< 16 tahun)')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->primigravida_terlalu_muda),

                                        Infolists\Components\TextEntry::make('primigravida_terlalu_tua')
                                            ->label('Primigravida Terlalu Tua (> 35 tahun)')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->primigravida_terlalu_tua),

                                        Infolists\Components\TextEntry::make('primigravida_tua_sekunder')
                                            ->label('Primigravida Tua Sekunder')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->primigravida_tua_sekunder),

                                        Infolists\Components\TextEntry::make('tinggi_badan_kurang_atau_sama_145')
                                            ->label('Tinggi Badan ≤ 145 cm')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->tinggi_badan_kurang_atau_sama_145),

                                        Infolists\Components\TextEntry::make('pernah_gagal_kehamilan')
                                            ->label('Pernah Gagal Kehamilan')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->pernah_gagal_kehamilan),

                                        Infolists\Components\TextEntry::make('pernah_vakum_atau_forceps')
                                            ->label('Pernah Melahirkan dengan Vakum/Forceps')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->pernah_vakum_atau_forceps),

                                        Infolists\Components\TextEntry::make('pernah_operasi_sesar')
                                            ->label('Pernah Operasi Sesar')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->pernah_operasi_sesar),

                                        Infolists\Components\TextEntry::make('pernah_melahirkan_bblr')
                                            ->label('Pernah Melahirkan BBLR')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->pernah_melahirkan_bblr),

                                        Infolists\Components\TextEntry::make('pernah_melahirkan_cacat_bawaan')
                                            ->label('Pernah Melahirkan Bayi Cacat')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->pernah_melahirkan_cacat_bawaan),

                                        Infolists\Components\TextEntry::make('anak_terkecil_kurang_2_tahun')
                                            ->label('Anak Terkecil < 2 Tahun')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->anak_terkecil_kurang_2_tahun),

                                        Infolists\Components\TextEntry::make('riwayat_kelainan_obstetri_sebelumnya')
                                            ->label('Riwayat Kelainan Obstetri')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->riwayat_kelainan_obstetri_sebelumnya),

                                        // Faktor Risiko 4 Poin (Lanjutan)
                                        Infolists\Components\TextEntry::make('anemia_hb_kurang_11')
                                            ->label('Anemia (HB < 11 g%)')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->anemia_hb_kurang_11),

                                        Infolists\Components\TextEntry::make('riwayat_penyakit_kronis')
                                            ->label('Riwayat Penyakit Kronis')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn($state) => $state ? '✓ Ya (4 poin)' : '✗ Tidak')
                                            ->visible(fn($record) => $record->riwayat_penyakit_kronis),
                                    ]),
                            ])
                            ->collapsible(),

                        Infolists\Components\Section::make('Rekomendasi')
                            ->schema([
                                Infolists\Components\TextEntry::make('rekomendasi')
                                    ->label('')
                                    ->listWithLineBreaks()
                                    ->bulleted()
                                    ->color('primary'),
                            ])
                            ->collapsed(false),
                    ]),
            ])
            ->bulkActions([
                // Bisa ditambahkan bulk actions jika diperlukan
            ]);
    }
}
