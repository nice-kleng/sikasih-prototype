<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeteksiRisikoResource\Pages;
use App\Filament\Resources\DeteksiRisikoResource\RelationManagers;
use App\Models\DeteksiRisiko;
use Filament\Forms;
use Filament\Forms\Form;
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
                            ->disabled(fn() => Auth::user()->hasRole('puskesmas')),
                        Forms\Components\Select::make('ibu_hamil_id')
                            ->label('Ibu Hamil')
                            ->relationship('ibuHamil', 'nama_lengkap')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DateTimePicker::make('waktu_deteksi')
                            ->label('Waktu Deteksi')
                            ->required()
                            ->native(false)
                            ->default(now()),
                    ])
                    ->columns(3),
            ]);
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

                Tables\Filters\Filter::make('skor_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('skor_min')
                                    ->label('Skor Minimum')
                                    ->numeric()
                                    ->placeholder('0'),
                                Forms\Components\TextInput::make('skor_max')
                                    ->label('Skor Maximum')
                                    ->numeric()
                                    ->placeholder('12'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['skor_min'],
                                fn(Builder $query, $skor): Builder => $query->where('total_skor', '>=', $skor),
                            )
                            ->when(
                                $data['skor_max'],
                                fn(Builder $query, $skor): Builder => $query->where('total_skor', '<=', $skor),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['skor_min'] ?? null) {
                            $indicators[] = 'Skor min: ' . $data['skor_min'];
                        }
                        if ($data['skor_max'] ?? null) {
                            $indicators[] = 'Skor max: ' . $data['skor_max'];
                        }
                        return $indicators;
                    }),

                Tables\Filters\Filter::make('tanggal_deteksi')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data deteksi risiko')
            ->emptyStateDescription('Data deteksi risiko akan muncul di sini setelah dilakukan pemeriksaan.')
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
            'view' => Pages\ViewDeteksiRisiko::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'delete',
            'delete_any',
        ];
    }
}
