<?php

namespace App\Filament\Resources\PuskesmasResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IbuHamilRelationManager extends RelationManager
{
    protected static string $relationship = 'ibuHamil';

    protected static ?string $title = 'Data Ibu Hamil';

    protected static ?string $modelLabel = 'Ibu Hamil';

    protected static ?string $pluralModelLabel = 'Ibu Hamil';

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pokok')
                    ->schema([
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nik')
                            ->label('NIK')
                            ->numeric()
                            ->required()
                            ->unique('ibu_hamils', 'nik', ignoreRecord: true)
                            ->maxLength(16)
                            ->minLength(16),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        Textarea::make('alamat_lengkap')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('kelurahan')
                            ->label('Kelurahan')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('no_telp')
                            ->label('No. WhatsApp')
                            ->tel()
                            ->maxLength(15)
                            ->placeholder('08xxxxxxxxxx'),
                        Select::make('pendidikan_terakhir')
                            ->label('Pendidikan Terakhir')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA/SMK' => 'SMA/SMK',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ])
                            ->native(false),
                        TextInput::make('pekerjaan')
                            ->label('Pekerjaan')
                            ->maxLength(255)
                            ->placeholder('IRT, Pegawai Swasta, dll'),
                        Select::make('status_pernikahan')
                            ->label('Status Pernikahan')
                            ->options([
                                'Menikah' => 'Menikah',
                                'Belum Menikah' => 'Belum Menikah',
                            ])
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Data Suami')
                    ->schema([
                        TextInput::make('dataSuami.nama_lengkap')
                            ->label('Nama Lengkap Suami')
                            ->maxLength(255),
                        TextInput::make('dataSuami.umur')
                            ->label('Umur Suami')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(150)
                            ->suffix('tahun'),
                        Select::make('dataSuami.pendidikan_terakhir')
                            ->label('Pendidikan Terakhir Suami')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA/SMK' => 'SMA/SMK',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ])
                            ->native(false),
                        TextInput::make('dataSuami.pekerjaan')
                            ->label('Pekerjaan Suami')
                            ->maxLength(255),
                        Select::make('dataSuami.is_has_bpjs')
                            ->label('Memiliki BPJS Kesehatan')
                            ->options([
                                1 => 'Ya',
                                0 => 'Tidak',
                            ])
                            ->native(false)
                            ->default(0),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_lengkap')
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('no_telp')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deteksi_risiko_count')
                    ->label('Deteksi Risiko')
                    ->counts('deteksiRisiko')
                    ->suffix(' kali')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kecamatan')
                    ->label('Kecamatan')
                    ->options(fn() => $this->getOwnerRecord()->ibuHamil()
                        ->distinct()
                        ->pluck('kecamatan', 'kecamatan')
                        ->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA/SMK' => 'SMA/SMK',
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                    ])
                    ->multiple(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Ibu Hamil')
                    ->icon('heroicon-o-plus')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['puskesmas_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    })
                    ->successNotificationTitle('Ibu Hamil berhasil ditambahkan'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => \App\Filament\Resources\IbuHamilResource::getUrl('view', ['record' => $record]))
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->successNotificationTitle('Data Ibu Hamil berhasil diperbarui'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Data Ibu Hamil berhasil dihapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Data Ibu Hamil terpilih berhasil dihapus'),
                ]),
            ])
            ->emptyStateHeading('Belum ada data Ibu Hamil')
            ->emptyStateDescription('Tambahkan data Ibu Hamil yang terdaftar di Puskesmas ini.')
            ->emptyStateIcon('heroicon-o-user-group')
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
