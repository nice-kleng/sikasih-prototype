<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IbuHamilResource\Pages;
use App\Filament\Resources\IbuHamilResource\RelationManagers;
use App\Filament\Resources\IbuHamilResource\RelationManagers\DeteksiRisikoRelationManager;
use App\Models\IbuHamil;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IbuHamilResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = IbuHamil::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Ibu Hamil';

    protected static ?string $modelLabel = 'Ibu Hamil';

    protected static ?string $pluralModelLabel = 'Ibu Hamil';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'read',
            'update',
            'delete',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isPuskesmas) {
            $query->where('puskesmas_id', $user->puskesmas->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
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
                            ->maxLength(16),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->native(false)
                            ->reactive()
                            ->displayFormat('d/m/Y'),
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
                            ->required(),
                        TextInput::make('no_telp')
                            ->label('Whatsapp'),
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
                            ]),
                        TextInput::make('pekerjaan')
                            ->maxLength(255),
                        TextInput::make('status_pernikahan')
                            ->maxLength(255),
                    ]),
                Section::make('Data Suami')
                    ->schema([
                        TextInput::make('dataSuami.nama_lengkap')
                            ->label('Nama Lengkap')
                            ->maxLength(255),
                        TextInput::make('dataSuami.umur')
                            ->label('Umur')
                            ->numeric(),
                        Select::make('dataSuami.pendidikan_terakhir')
                            ->label('Pendidikan Terakhir')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA/SMK' => 'SMA/SMK',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ]),
                        TextInput::make('dataSuami.pekerjaan')
                            ->maxLength(255),
                        Select::make('dataSuami.is_has_bpjs')
                            ->label('Memiliki BPJS Kesehatan')
                            ->options([
                                1 => 'Ya',
                                0 => 'Tidak',
                            ]),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Pokok')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_lengkap')->label('Nama Lengkap'),
                        Infolists\Components\TextEntry::make('nik')->label('NIK'),
                        Infolists\Components\TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date('d/m/Y'),
                        Infolists\Components\TextEntry::make('alamat_lengkap')->label('Alamat Lengkap'),
                        Infolists\Components\TextEntry::make('kelurahan')->label('Kelurahan'),
                        Infolists\Components\TextEntry::make('kecamatan')->label('Kecamatan'),
                        Infolists\Components\TextEntry::make('no_telp')->label('Whatsapp'),
                        Infolists\Components\TextEntry::make('pendidikan_terakhir')->label('Pendidikan Terakhir'),
                        Infolists\Components\TextEntry::make('pekerjaan')->label('Pekerjaan'),
                        Infolists\Components\TextEntry::make('status_pernikahan')->label('Status Pernikahan'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Data Suami')
                    ->relationship('dataSuami')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_lengkap')->label('Nama Lengkap'),
                        Infolists\Components\TextEntry::make('umur')->label('Usia'),
                        Infolists\Components\TextEntry::make('pendidikan_terakhir')->label('Pendidikan Terakhir'),
                        Infolists\Components\TextEntry::make('pekerjaan')->label('Pekerjaan'),
                        Infolists\Components\TextEntry::make('is_has_bpjs')->label('Kepemilikan BPJS'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('puskesmas.nama_puskesmas')->label('Puskesmas')->searchable()->sortable()->visible(function () {
                    return Auth::user()->hasRole('puskesmas');
                }),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nik')->label('NIK')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_telp')->label('No. Telp')->searchable(),
            ])
            ->filters([
                SelectFilter::make('puskesmas')
                    ->label('Puskesmas')
                    ->relationship('puskesmas', 'nama_puskesmas')
                    ->searchable()
                    ->preload()
                    ->visible(function () {
                        return Auth::user()->hasRole('super_admin');
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DeteksiRisikoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIbuHamils::route('/'),
            'create' => Pages\CreateIbuHamil::route('/create'),
            'view' => Pages\ViewIbuHamil::route('/{record}'),
            'edit' => Pages\EditIbuHamil::route('/{record}/edit'),
        ];
    }
}
