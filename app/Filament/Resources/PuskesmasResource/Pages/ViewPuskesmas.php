<?php

namespace App\Filament\Resources\PuskesmasResource\Pages;

use App\Filament\Resources\PuskesmasResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPuskesmas extends ViewRecord
{
    protected static string $resource = PuskesmasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi User & Akun')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Nama Admin Puskesmas'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email')
                            ->copyable()
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('user.no_telepon')
                            ->label('No. Telepon User')
                            ->icon('heroicon-m-phone'),
                    ])
                    ->columns(3)
                    ->visible(fn() => auth()->user()->hasRole('super_admin')),

                Infolists\Components\Section::make('Data Puskesmas')
                    ->schema([
                        Infolists\Components\TextEntry::make('kode_puskesmas')
                            ->label('Kode Puskesmas')
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('nama_puskesmas')
                            ->label('Nama Puskesmas')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('kecamatan')
                            ->label('Kecamatan')
                            ->icon('heroicon-m-map-pin'),
                        Infolists\Components\TextEntry::make('kabupaten')
                            ->label('Kabupaten/Kota')
                            ->icon('heroicon-m-map-pin'),
                        Infolists\Components\TextEntry::make('provinsi')
                            ->label('Provinsi')
                            ->icon('heroicon-m-map-pin'),
                        Infolists\Components\TextEntry::make('kode_pos')
                            ->label('Kode Pos'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Kontak & Kepegawaian')
                    ->schema([
                        Infolists\Components\TextEntry::make('no_telepon')
                            ->label('No. Telepon Puskesmas')
                            ->icon('heroicon-m-phone')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email Puskesmas')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('kepala_puskesmas')
                            ->label('Kepala Puskesmas')
                            ->icon('heroicon-m-user'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Fasilitas & Status')
                    ->schema([
                        Infolists\Components\TextEntry::make('fasilitas')
                            ->label('Fasilitas')
                            ->badge()
                            ->separator(',')
                            ->color('success')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('tipe')
                            ->label('Tipe Puskesmas')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'poned' => 'success',
                                'non_poned' => 'gray',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'poned' => 'PONED',
                                'non_poned' => 'Non PONED',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'aktif' => 'success',
                                'nonaktif' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Statistik')
                    ->schema([
                        Infolists\Components\TextEntry::make('ibu_hamil_count')
                            ->label('Jumlah Ibu Hamil')
                            ->state(fn($record) => $record->ibuHamil()->count())
                            ->badge()
                            ->color('info')
                            ->suffix(' Orang'),
                        Infolists\Components\TextEntry::make('deteksi_risiko_count')
                            ->label('Total Deteksi Risiko')
                            ->state(fn($record) => $record->deteksiRisiko()->count())
                            ->badge()
                            ->color('warning')
                            ->suffix(' Kali'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diperbarui')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
