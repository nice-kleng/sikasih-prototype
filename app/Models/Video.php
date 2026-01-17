<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'youtube_id',
        'thumbnail',
        'kategori',
        'durasi_detik',
        'views',
        'urutan',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'durasi_detik' => 'integer',
        'views' => 'integer',
        'urutan' => 'integer',
    ];

    /**
     * Get formatted duration
     */
    public function getDurasiFormatAttribute(): ?string
    {
        if (!$this->durasi_detik) {
            return null;
        }

        $minutes = floor($this->durasi_detik / 60);
        $seconds = $this->durasi_detik % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get YouTube URL
     */
    public function getYoutubeUrlAttribute(): string
    {
        return "https://www.youtube.com/watch?v={$this->youtube_id}";
    }

    /**
     * Get YouTube embed URL
     */
    public function getYoutubeEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    /**
     * Get kategori label
     */
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'persiapan_kehamilan' => 'Persiapan Kehamilan',
            'perkembangan_janin' => 'Perkembangan Janin',
            'senam_hamil' => 'Senam Hamil',
            'nutrisi' => 'Nutrisi',
            'persiapan_persalinan' => 'Persiapan Persalinan',
            'perawatan_bayi' => 'Perawatan Bayi',
            'lainnya' => 'Lainnya',
            default => $this->kategori,
        };
    }

    /**
     * Scope for published videos
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for ordered videos
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    /**
     * Scope by kategori
     */
    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Increment views
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
