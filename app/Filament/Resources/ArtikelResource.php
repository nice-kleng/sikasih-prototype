<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

class ArtikelResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Konten & Edukasi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Artikel';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel';

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
                Forms\Components\Section::make('Informasi Artikel')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Artikel')
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
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'nutrisi' => 'Nutrisi',
                                'olahraga' => 'Olahraga',
                                'perkembangan_janin' => 'Perkembangan Janin',
                                'tanda_bahaya' => 'Tanda Bahaya',
                                'persiapan_persalinan' => 'Persiapan Persalinan',
                                'tips_kehamilan' => 'Tips Kehamilan',
                                'kesehatan_ibu' => 'Kesehatan Ibu',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('penulis_id')
                            ->relationship('penulis', 'name')
                            ->label('Penulis')
                            ->searchable()
                            ->preload()
                            ->default(fn() => auth()->id()),
                    ])->columns(2),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar_utama')
                            ->label('Gambar Utama')
                            ->image()
                            ->imageEditor()
                            ->directory('artikel')
                            ->maxSize(2048)
                            ->helperText('Ukuran maksimal 2MB')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Ringkasan singkat artikel (max 500 karakter)')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('konten')
                            ->label('Konten Artikel')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'heading',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Ketik dan tekan Enter')
                            ->helperText('Tag untuk memudahkan pencarian')
                            ->separator(',')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan Publikasi')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft')
                            ->live(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->native(false)
                            ->visible(fn(Forms\Get $get) => $get('status') === 'published')
                            ->default(now()),
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
                Tables\Columns\ImageColumn::make('gambar_utama')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(url('/images/no-image.png')),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'nutrisi',
                        'success' => 'olahraga',
                        'info' => 'perkembangan_janin',
                        'danger' => 'tanda_bahaya',
                        'warning' => 'persiapan_persalinan',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'nutrisi' => 'Nutrisi',
                        'olahraga' => 'Olahraga',
                        'perkembangan_janin' => 'Perkembangan Janin',
                        'tanda_bahaya' => 'Tanda Bahaya',
                        'persiapan_persalinan' => 'Persiapan Persalinan',
                        'tips_kehamilan' => 'Tips Kehamilan',
                        'kesehatan_ibu' => 'Kesehatan Ibu',
                        'lainnya' => 'Lainnya',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('penulis.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => number_format($state)),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dipublikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
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
                        'nutrisi' => 'Nutrisi',
                        'olahraga' => 'Olahraga',
                        'perkembangan_janin' => 'Perkembangan Janin',
                        'tanda_bahaya' => 'Tanda Bahaya',
                        'persiapan_persalinan' => 'Persiapan Persalinan',
                        'tips_kehamilan' => 'Tips Kehamilan',
                        'kesehatan_ibu' => 'Kesehatan Ibu',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\Filter::make('published')
                    ->label('Sudah Dipublikasi')
                    ->query(fn($query) => $query->whereNotNull('published_at')),
            ])
            ->actions([
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Artikel $record) {
                        $record->update([
                            'status' => 'published',
                            'published_at' => now(),
                        ]);
                    })
                    ->visible(fn(Artikel $record) => $record->status !== 'published'),
                Tables\Actions\Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Artikel $record) {
                        $record->update([
                            'status' => 'draft',
                            'published_at' => null,
                        ]);
                    })
                    ->visible(fn(Artikel $record) => $record->status === 'published'),
                Tables\Actions\ViewAction::make(),
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
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'published',
                                    'published_at' => now(),
                                ]);
                            });
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Header Section dengan Gambar
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\ImageEntry::make('gambar_utama')
                            ->label('')
                            ->height(400)
                            ->defaultImageUrl(url('/images/no-image.png'))
                            ->columnSpanFull(),
                    ])
                    ->collapsed(false),

                // Informasi Utama
                Infolists\Components\Section::make('Informasi Artikel')
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
                            ->icon('heroicon-o-link')
                            ->copyable()
                            ->copyMessage('Slug disalin!')
                            ->copyMessageDuration(1500),

                        Infolists\Components\TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'nutrisi' => 'primary',
                                'olahraga' => 'success',
                                'perkembangan_janin' => 'info',
                                'tanda_bahaya' => 'danger',
                                'persiapan_persalinan' => 'warning',
                                'tips_kehamilan' => 'purple',
                                'kesehatan_ibu' => 'pink',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'nutrisi' => 'Nutrisi',
                                'olahraga' => 'Olahraga',
                                'perkembangan_janin' => 'Perkembangan Janin',
                                'tanda_bahaya' => 'Tanda Bahaya',
                                'persiapan_persalinan' => 'Persiapan Persalinan',
                                'tips_kehamilan' => 'Tips Kehamilan',
                                'kesehatan_ibu' => 'Kesehatan Ibu',
                                'lainnya' => 'Lainnya',
                                default => $state,
                            }),

                        Infolists\Components\TextEntry::make('penulis.name')
                            ->label('Penulis')
                            ->icon('heroicon-o-user')
                            ->placeholder('Tidak ada penulis'),

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
                    ])->columns(3),

                // Ringkasan
                Infolists\Components\Section::make('Ringkasan')
                    ->schema([
                        Infolists\Components\TextEntry::make('excerpt')
                            ->label('')
                            ->formatStateUsing(fn(string $state): HtmlString => new HtmlString(
                                '<div class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed italic">' .
                                    nl2br(e($state)) .
                                    '</div>'
                            ))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // Konten Artikel
                Infolists\Components\Section::make('Konten Artikel')
                    ->schema([
                        Infolists\Components\TextEntry::make('konten')
                            ->label('')
                            ->html()
                            ->formatStateUsing(fn(?string $state): HtmlString => new HtmlString(
                                '<div class="prose prose-lg dark:prose-invert max-w-none">' .
                                    ($state ?? '<p class="text-gray-500">Tidak ada konten</p>') .
                                    '</div>'
                            ))
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                // Tags & Metadata
                Infolists\Components\Section::make('Tags & Metadata')
                    ->schema([
                        Infolists\Components\TextEntry::make('tags')
                            ->label('Tags')
                            ->badge()
                            ->separator(',')
                            ->color('primary')
                            ->placeholder('Tidak ada tags')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('views')
                            ->label('Total Views')
                            ->icon('heroicon-o-eye')
                            ->formatStateUsing(fn($state) => number_format($state))
                            ->color('success'),

                        Infolists\Components\TextEntry::make('reading_time')
                            ->label('Estimasi Waktu Baca')
                            ->icon('heroicon-o-clock')
                            ->getStateUsing(function (Artikel $record) {
                                $words = str_word_count(strip_tags($record->konten));
                                $minutes = ceil($words / 200); // Rata-rata 200 kata per menit
                                return $minutes . ' menit';
                            })
                            ->color('info'),

                        Infolists\Components\TextEntry::make('word_count')
                            ->label('Jumlah Kata')
                            ->icon('heroicon-o-document-text')
                            ->getStateUsing(function (Artikel $record) {
                                return number_format(str_word_count(strip_tags($record->konten))) . ' kata';
                            })
                            ->color('warning'),
                    ])->columns(3),

                // Informasi Publikasi
                Infolists\Components\Section::make('Informasi Publikasi')
                    ->schema([
                        Infolists\Components\TextEntry::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum dipublikasikan')
                            ->color('success'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->icon('heroicon-o-clock')
                            ->dateTime('d F Y, H:i')
                            ->color('gray'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('d F Y, H:i')
                            ->color('gray'),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
            'view' => Pages\ViewArtikel::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'draft')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
