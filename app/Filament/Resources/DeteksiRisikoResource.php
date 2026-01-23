<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeteksiRisikoResource\Pages;
use App\Filament\Resources\DeteksiRisikoResource\RelationManagers;
use App\Models\DeteksiRisiko;
use App\Models\IbuHamil;
use App\Models\Puskesmas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeteksiRisikoResource extends Resource
{
    protected static ?string $model = DeteksiRisiko::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Data Pemeriksaan';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Deteksi Risiko';

    protected static ?string $modelLabel = 'Deteksi Risiko';

    protected static ?string $pluralModelLabel = 'Deteksi Risiko';

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            return static::getModel()::count();
        }

        if ($user->hasRole('puskesmas')) {
            return static::getModel()::where('puskesmas_id', $user->puskesmas->id)->count();
        }

        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user->hasRole('puskesmas')) {
            return $query->where('puskesmas_id', $user->puskesmas->id);
        }

        return $query;
    }

    protected static function getSkorMapping(): array
    {
        return [
            'primigravida_anak_pertama' => 2,
            'primigravida_terlalu_muda' => 4,
            'primigravida_terlalu_tua' => 4,
            'primigravida_tua_sekunder' => 4,
            'tinggi_badan_kurang_atau_sama_145' => 4,
            'pernah_gagal_kehamilan' => 4,
            'pernah_vakum_atau_forceps' => 4,
            'pernah_operasi_sesar' => 4,
            'pernah_melahirkan_bblr' => 4,
            'pernah_melahirkan_cacat_bawaan' => 4,
            'anemia_hb_kurang_11' => 4,
            'riwayat_penyakit_kronis' => 4,
            'riwayat_kelainan_obstetri_sebelumnya' => 4,
            'anak_terkecil_kurang_2_tahun' => 4,
            'hamil_kembar' => 4,
            'hidramnion' => 4,
            'bayi_mati_dalam_kandungan' => 4,
            'kehamilan_lebih_bulan' => 4,
            'letak_sungsang' => 8,
            'letak_lintang' => 8,
            'perdarahan_dalam_kehamilan_ini' => 8,
            'preeklampsia' => 8,
            'eklampsia' => 8,
        ];
    }

    protected static function hitungSkor(Get $get): int
    {
        $skor = 0;
        $skorMapping = self::getSkorMapping();

        foreach ($skorMapping as $field => $nilai) {
            if ($get($field)) {
                $skor += $nilai;
            }
        }

        return $skor;
    }

    protected static function tentukanKategori(int $skor): string
    {
        if ($skor >= 2 && $skor <= 6 || $skor == 0) {
            return 'KRR (Kehamilan Risiko Rendah)';
        } elseif ($skor >= 7 && $skor <= 12) {
            return 'KRT (Kehamilan Risiko Tinggi)';
        } else {
            return 'KRST (Kehamilan Risiko Sangat Tinggi)';
        }
    }

    protected static function buatRekomendasi(int $skor, Get $get): array
    {
        $rekomendasi = [];

        // Rekomendasi umum berdasarkan kategori
        if ($skor < 2) {
            $rekomendasi[] = 'Lakukan pemeriksaan rutin sesuai jadwal ANC.';
            $rekomendasi[] = 'Konsumsi makanan bergizi seimbang.';
            $rekomendasi[] = 'Istirahat yang cukup.';
            $rekomendasi[] = 'Hindari stress berlebihan.';
        } elseif ($skor >= 2 && $skor < 6) {
            $rekomendasi[] = 'Rujuk ke Puskesmas PONED untuk pemeriksaan lanjutan.';
            $rekomendasi[] = 'Lakukan pemeriksaan ANC lebih intensif.';
            $rekomendasi[] = 'Monitoring kondisi ibu dan janin secara berkala.';
            $rekomendasi[] = 'Siapkan rencana persalinan di fasilitas kesehatan.';
        } else {
            $rekomendasi[] = 'SEGERA rujuk ke Rumah Sakit untuk penanganan lebih lanjut.';
            $rekomendasi[] = 'Perlu pemeriksaan dan monitoring intensif oleh dokter SpOG.';
            $rekomendasi[] = 'Siapkan donor darah dan fasilitas emergensi.';
            $rekomendasi[] = 'Pastikan keluarga siaga dan siap untuk rujukan 24 jam.';
        }

        // Rekomendasi spesifik berdasarkan faktor risiko
        if ($get('preeklampsia') || $get('eklampsia')) {
            $rekomendasi[] = 'Monitoring tekanan darah secara rutin setiap hari.';
            $rekomendasi[] = 'Batasi konsumsi garam.';
        }

        if ($get('anemia_hb_kurang_11')) {
            $rekomendasi[] = 'Konsumsi tablet Fe (zat besi) sesuai anjuran.';
            $rekomendasi[] = 'Perbanyak makanan tinggi zat besi (daging merah, sayuran hijau).';
        }

        if ($get('hamil_kembar')) {
            $rekomendasi[] = 'Perlu USG lebih sering untuk monitoring perkembangan janin.';
            $rekomendasi[] = 'Istirahat lebih banyak dari kehamilan tunggal.';
        }

        if ($get('letak_sungsang') || $get('letak_lintang')) {
            $rekomendasi[] = 'Diskusikan rencana persalinan dengan dokter (kemungkinan SC).';
            $rekomendasi[] = 'Lakukan senam hamil atau posisi khusus untuk memperbaiki posisi janin.';
        }

        if ($get('riwayat_penyakit_kronis')) {
            $rekomendasi[] = 'Konsultasi dengan dokter spesialis terkait untuk manajemen penyakit kronis.';
            $rekomendasi[] = 'Rutin kontrol dan minum obat sesuai anjuran dokter.';
        }

        return $rekomendasi;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('puskesmas_id')
                            ->label('Puskesmas')
                            ->relationship('puskesmas', 'nama_puskesmas')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                $user = Auth::user();
                                if ($user->hasRole('puskesmas')) {
                                    return $user->puskesmas->id;
                                }
                                return null;
                            })
                            ->disabled(fn() => Auth::user()->hasRole('puskesmas'))
                            ->dehydrated(),
                        Forms\Components\Select::make('ibu_hamil_id')
                            ->label('Ibu Hamil')
                            ->options(function (Get $get) {
                                $puskesmasId = $get('puskesmas_id');
                                if (!$puskesmasId) {
                                    return [];
                                }
                                return IbuHamil::where('puskesmas_id', $puskesmasId)
                                    ->pluck('nama_lengkap', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state) {
                                    $ibu = IbuHamil::find($state);
                                    if ($ibu) {
                                        $set('info_ibu', [
                                            'nik' => $ibu->nik,
                                            'tanggal_lahir' => date('d/m/Y', strtotime($ibu->tanggal_lahir)),
                                            'alamat' => $ibu->alamat_lengkap,
                                        ]);
                                    }
                                }
                            }),
                        Forms\Components\DateTimePicker::make('waktu_deteksi')
                            ->label('Waktu Deteksi')
                            ->required()
                            ->native(false)
                            ->default(now()),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Data Reproduksi')
                    ->description('Isi data riwayat reproduksi ibu hamil')
                    ->schema([
                        Forms\Components\TextInput::make('dataReproduksi.usia_pertama_menikah')
                            ->label('Usia Pertama Menikah')
                            ->numeric()
                            ->suffix('tahun')
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('dataReproduksi.usia_hamil_pertama')
                            ->label('Usia Hamil Pertama')
                            ->numeric()
                            ->suffix('tahun')
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('dataReproduksi.jumlah_kehamilan')
                            ->label('Jumlah Kehamilan (G)')
                            ->numeric()
                            ->minValue(0)
                            ->default(1),
                        Forms\Components\TextInput::make('dataReproduksi.jumlah_persalinan')
                            ->label('Jumlah Persalinan (P)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Forms\Components\TextInput::make('dataReproduksi.jumlah_anak_hidup')
                            ->label('Jumlah Anak Hidup (A)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Forms\Components\TextInput::make('dataReproduksi.jumlah_keguguran')
                            ->label('Jumlah Keguguran')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Forms\Components\Textarea::make('dataReproduksi.riwayat_persalinan_sebelumnya')
                            ->label('Riwayat Persalinan Sebelumnya')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Persalinan normal, SC, dll'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Skrining Faktor Risiko')
                    ->description('Centang faktor risiko yang terdeteksi. Skor akan dihitung otomatis.')
                    ->schema([
                        Forms\Components\Placeholder::make('info_skrining')
                            ->label('')
                            ->content('Silakan centang faktor risiko yang ada pada ibu hamil. Sistem akan menghitung skor dan kategori risiko secara otomatis.')
                            ->columnSpanFull(),

                        // Faktor Risiko 2 Poin
                        Forms\Components\Fieldset::make('Faktor Risiko - 2 Poin')
                            ->schema([
                                Forms\Components\Checkbox::make('primigravida_anak_pertama')
                                    ->label('Primigravida (Anak Pertama)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get))
                                    ->helperText('Skor: 2 poin'),
                            ])
                            ->columns(1),

                        // Faktor Risiko 4 Poin
                        Forms\Components\Fieldset::make('Faktor Risiko - 4 Poin')
                            ->schema([
                                Forms\Components\Checkbox::make('primigravida_terlalu_muda')
                                    ->label('Primigravida Terlalu Muda (< 16 tahun)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('primigravida_terlalu_tua')
                                    ->label('Primigravida Terlalu Tua (> 35 tahun)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('primigravida_tua_sekunder')
                                    ->label('Primigravida Tua Sekunder (Anak terakhir > 35 tahun)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('tinggi_badan_kurang_atau_sama_145')
                                    ->label('Tinggi Badan ≤ 145 cm')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('pernah_gagal_kehamilan')
                                    ->label('Pernah Gagal Kehamilan')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('pernah_vakum_atau_forceps')
                                    ->label('Pernah Melahirkan dengan Vakum/Forceps')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('pernah_operasi_sesar')
                                    ->label('Pernah Operasi Sesar')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('pernah_melahirkan_bblr')
                                    ->label('Pernah Melahirkan BBLR (< 2500 gram)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('pernah_melahirkan_cacat_bawaan')
                                    ->label('Pernah Melahirkan Bayi Cacat Bawaan')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('anemia_hb_kurang_11')
                                    ->label('Anemia (HB < 11 g%)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('riwayat_penyakit_kronis')
                                    ->label('Riwayat Penyakit Kronis (DM, Hipertensi, Jantung, dll)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('riwayat_kelainan_obstetri_sebelumnya')
                                    ->label('Riwayat Kelainan Obstetri Sebelumnya')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('anak_terkecil_kurang_2_tahun')
                                    ->label('Anak Terkecil < 2 Tahun')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('hamil_kembar')
                                    ->label('Hamil Kembar (2 atau lebih)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('hidramnion')
                                    ->label('Hidramnion (Cairan ketuban berlebih)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('bayi_mati_dalam_kandungan')
                                    ->label('Bayi Mati Dalam Kandungan')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('kehamilan_lebih_bulan')
                                    ->label('Kehamilan Lebih Bulan (> 42 minggu)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                            ])
                            ->columns(2),

                        // Faktor Risiko 8 Poin
                        Forms\Components\Fieldset::make('Faktor Risiko - 8 Poin (BAHAYA TINGGI)')
                            ->schema([
                                Forms\Components\Checkbox::make('letak_sungsang')
                                    ->label('Letak Sungsang pada Usia Kehamilan > 32 minggu')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('letak_lintang')
                                    ->label('Letak Lintang pada Usia Kehamilan > 32 minggu')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('perdarahan_dalam_kehamilan_ini')
                                    ->label('Perdarahan Dalam Kehamilan Ini')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('preeklampsia')
                                    ->label('Preeklampsia / Hipertensi Dalam Kehamilan')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                                Forms\Components\Checkbox::make('eklampsia')
                                    ->label('Eklampsia (Kejang pada Kehamilan)')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateSkorKategori($set, $get)),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Section::make('Hasil Penilaian')
                    ->description('Hasil kalkulasi otomatis berdasarkan faktor risiko yang dipilih')
                    ->schema([
                        Forms\Components\Placeholder::make('total_skor_display')
                            ->label('Total Skor')
                            ->content(function (Get $get) {
                                $skor = self::hitungSkor($get);
                                $warna = $skor < 2 ? 'success' : ($skor < 6 ? 'warning' : 'danger');
                                return new \Illuminate\Support\HtmlString(
                                    "<div class='text-3xl font-bold text-{$warna}-600'>{$skor} Poin</div>"
                                );
                            }),
                        Forms\Components\Placeholder::make('kategori_display')
                            ->label('Kategori Risiko')
                            ->content(function (Get $get) {
                                $skor = self::hitungSkor($get);
                                $kategori = self::tentukanKategori($skor);
                                $badges = [
                                    'KRR (Kehamilan Risiko Rendah)' => '<span class="inline-flex items-center px-4 py-2 text-sm font-semibold text-green-800 bg-green-100 rounded-full">✓ KRR - Kehamilan Risiko Rendah</span>',
                                    'KRT (Kehamilan Risiko Tinggi)' => '<span class="inline-flex items-center px-4 py-2 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">⚠ KRT - Kehamilan Risiko Tinggi</span>',
                                    'KRST (Kehamilan Risiko Sangat Tinggi)' => '<span class="inline-flex items-center px-4 py-2 text-sm font-semibold text-red-800 bg-red-100 rounded-full">⚠ KRST - Kehamilan Risiko Sangat Tinggi</span>',
                                ];
                                return new \Illuminate\Support\HtmlString($badges[$kategori] ?? $kategori);
                            }),
                        Forms\Components\Hidden::make('total_skor')
                            ->default(0)
                            ->dehydrated(),
                        Forms\Components\Hidden::make('kategori')
                            ->default('KRR (Kehamilan Risiko Rendah)')
                            ->dehydrated(),
                        Forms\Components\Hidden::make('rekomendasi')
                            ->default([])
                            ->dehydrated(),
                    ])
                    ->columns(2)
                    ->collapsed(false),
            ]);
    }

    protected static function updateSkorKategori(Set $set, Get $get): void
    {
        $skor = self::hitungSkor($get);
        $kategori = self::tentukanKategori($skor);
        $rekomendasi = self::buatRekomendasi($skor, $get);

        $set('total_skor', $skor);
        $set('kategori', $kategori);
        $set('rekomendasi', $rekomendasi);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('waktu_deteksi')
                    ->label('Waktu Deteksi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('ibuHamil.nama_lengkap')
                    ->label('Nama Ibu Hamil')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn($record) => 'NIK: ' . $record->ibuHamil->nik),

                Tables\Columns\TextColumn::make('ibuHamil.no_telp')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('puskesmas.nama_puskesmas')
                    ->label('Puskesmas')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visible(fn() => Auth::user()->hasRole('super_admin')),

                Tables\Columns\TextColumn::make('dataReproduksi.jumlah_kehamilan')
                    ->label('Kehamilan Ke')
                    ->default('-')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dicatat')
                    ->dateTime('d M Y')
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

                Tables\Filters\SelectFilter::make('puskesmas')
                    ->label('Puskesmas')
                    ->relationship('puskesmas', 'nama_puskesmas')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => Auth::user()->hasRole('super_admin')),

                Tables\Filters\Filter::make('risiko_tinggi')
                    ->label('Risiko Tinggi/Sangat Tinggi')
                    ->query(fn(Builder $query): Builder => $query->where('total_skor', '>=', 2))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat_ibu_hamil')
                    ->label('Lihat Ibu Hamil')
                    ->icon('heroicon-o-user')
                    ->url(fn($record) => \App\Filament\Resources\IbuHamilResource::getUrl('view', ['record' => $record->ibu_hamil_id]))
                    ->color('info')
                    ->visible(fn($record) => $record->ibu_hamil_id),
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data deteksi risiko')
            ->emptyStateDescription('Klik tombol "Tambah" untuk melakukan deteksi risiko baru.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeteksiRisikos::route('/'),
            'create' => Pages\CreateDeteksiRisiko::route('/create'),
            'view' => Pages\ViewDeteksiRisiko::route('/{record}'),
            'edit' => Pages\EditDeteksiRisiko::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
