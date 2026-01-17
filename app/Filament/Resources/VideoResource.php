<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;

class VideoResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Konten & Edukasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Video Edukasi';

    protected static ?string $modelLabel = 'Video Edukasi';

    protected static ?string $pluralModelLabel = 'Video Edukasi';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Video')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Video')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly version dari judul')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'persiapan_kehamilan' => 'Persiapan Kehamilan',
                                'perkembangan_janin' => 'Perkembangan Janin',
                                'senam_hamil' => 'Senam Hamil',
                                'nutrisi' => 'Nutrisi',
                                'persiapan_persalinan' => 'Persiapan Persalinan',
                                'perawatan_bayi' => 'Perawatan Bayi',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('Link YouTube')
                    ->description('Masukkan ID video YouTube atau link lengkap')
                    ->schema([
                        Forms\Components\TextInput::make('youtube_id')
                            ->label('YouTube Video ID')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: jika link YouTube adalah https://www.youtube.com/watch?v=ABC123xyz, maka ID-nya adalah ABC123xyz')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Extract YouTube ID from various URL formats
                                if (Str::contains($state, 'youtube.com') || Str::contains($state, 'youtu.be')) {
                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $state, $matches);
                                    if (isset($matches[1])) {
                                        $set('youtube_id', $matches[1]);
                                    }
                                }

                                // Auto-generate thumbnail
                                $videoId = $matches[1] ?? $state;
                                if (strlen($videoId) === 11) {
                                    $set('thumbnail', "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg");
                                }
                            })
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('thumbnail')
                            ->label('Thumbnail URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Otomatis terisi dari YouTube. Bisa diganti dengan URL custom.')
                            ->columnSpanFull(),
                        Forms\Components\ViewField::make('youtube_preview')
                            ->label('Preview Video')
                            ->view('filament.forms.components.youtube-preview')
                            ->visible(fn(Forms\Get $get) => filled($get('youtube_id')))
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('durasi_detik')
                            ->label('Durasi (detik)')
                            ->numeric()
                            ->helperText('Opsional - untuk statistik'),
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin di atas urutannya'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'archived' => 'Archived',
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('draft'),
                        Forms\Components\TextInput::make('views')
                            ->label('Jumlah Views')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->size(80),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'persiapan_kehamilan',
                        'success' => 'perkembangan_janin',
                        'warning' => 'senam_hamil',
                        'info' => 'nutrisi',
                        'danger' => 'persiapan_persalinan',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'persiapan_kehamilan' => 'Persiapan Kehamilan',
                        'perkembangan_janin' => 'Perkembangan Janin',
                        'senam_hamil' => 'Senam Hamil',
                        'nutrisi' => 'Nutrisi',
                        'persiapan_persalinan' => 'Persiapan Persalinan',
                        'perawatan_bayi' => 'Perawatan Bayi',
                        'lainnya' => 'Lainnya',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('durasi_format')
                    ->label('Durasi')
                    ->getStateUsing(fn(Video $record) => $record->durasi_format ?? '-')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => number_format($state)),
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                        'danger' => 'archived',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'persiapan_kehamilan' => 'Persiapan Kehamilan',
                        'perkembangan_janin' => 'Perkembangan Janin',
                        'senam_hamil' => 'Senam Hamil',
                        'nutrisi' => 'Nutrisi',
                        'persiapan_persalinan' => 'Persiapan Persalinan',
                        'perawatan_bayi' => 'Perawatan Bayi',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-play')
                    ->color('info')
                    ->url(fn(Video $record) => "https://www.youtube.com/watch?v={$record->youtube_id}", shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['status' => 'published'])),
                    Tables\Actions\BulkAction::make('archive')
                        ->label('Archive Selected')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->action(fn($records) => $records->each->update(['status' => 'archived'])),
                ]),
            ])
            ->defaultSort('urutan', 'asc')
            ->reorderable('urutan');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Preview Video')
                    ->schema([
                        Infolists\Components\ViewEntry::make('youtube_embed')
                            ->label('')
                            ->view('filament.infolists.components.youtube-embed')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Informasi Video')
                    ->schema([
                        Infolists\Components\TextEntry::make('judul')
                            ->label('Judul')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug')
                            ->badge()
                            ->color('gray')
                            ->copyable()
                            ->copyMessage('Slug disalin!')
                            ->copyMessageDuration(1500),
                        Infolists\Components\TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'persiapan_kehamilan' => 'primary',
                                'perkembangan_janin' => 'success',
                                'senam_hamil' => 'warning',
                                'nutrisi' => 'info',
                                'persiapan_persalinan' => 'danger',
                                'perawatan_bayi' => 'purple',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'persiapan_kehamilan' => 'Persiapan Kehamilan',
                                'perkembangan_janin' => 'Perkembangan Janin',
                                'senam_hamil' => 'Senam Hamil',
                                'nutrisi' => 'Nutrisi',
                                'persiapan_persalinan' => 'Persiapan Persalinan',
                                'perawatan_bayi' => 'Perawatan Bayi',
                                'lainnya' => 'Lainnya',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->placeholder('Tidak ada deskripsi'),
                    ])->columns(2),

                Infolists\Components\Section::make('Detail YouTube')
                    ->schema([
                        Infolists\Components\TextEntry::make('youtube_id')
                            ->label('YouTube ID')
                            ->copyable()
                            ->copyMessage('YouTube ID disalin!')
                            ->badge()
                            ->color('danger'),
                        Infolists\Components\TextEntry::make('youtube_url')
                            ->label('YouTube URL')
                            ->url(fn(Video $record) => "https://www.youtube.com/watch?v={$record->youtube_id}")
                            ->openUrlInNewTab()
                            ->copyable()
                            ->icon('heroicon-o-link'),
                        Infolists\Components\ImageEntry::make('thumbnail')
                            ->label('Thumbnail')
                            ->height(150)
                            ->columnSpanFull(),
                    ])->columns(2),

                Infolists\Components\Section::make('Statistik & Pengaturan')
                    ->schema([
                        Infolists\Components\TextEntry::make('durasi_format')
                            ->label('Durasi')
                            ->getStateUsing(fn(Video $record) => $record->durasi_format ?? 'Tidak diketahui')
                            ->icon('heroicon-o-clock'),
                        Infolists\Components\TextEntry::make('views')
                            ->label('Total Views')
                            ->formatStateUsing(fn($state) => number_format($state))
                            ->icon('heroicon-o-eye'),
                        Infolists\Components\TextEntry::make('urutan')
                            ->label('Urutan Tampil')
                            ->badge()
                            ->color('gray'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'published' => 'success',
                                'draft' => 'warning',
                                'archived' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum dipublikasikan')
                            ->icon('heroicon-o-calendar'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-clock'),
                    ])->columns(3),
            ]);
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'view' => Pages\ViewVideo::route('/{record}'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'published')->count();
    }
}
