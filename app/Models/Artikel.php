<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'penulis_id',
        'judul',
        'slug',
        'excerpt',
        'konten',
        'gambar_utama',
        'kategori',
        'tags',
        'views',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Get tags as array
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }

        return array_map('trim', explode(',', $this->tags));
    }

    /**
     * Get kategori label
     */
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'nutrisi' => 'Nutrisi',
            'olahraga' => 'Olahraga',
            'perkembangan_janin' => 'Perkembangan Janin',
            'tanda_bahaya' => 'Tanda Bahaya',
            'persiapan_persalinan' => 'Persiapan Persalinan',
            'tips_kehamilan' => 'Tips Kehamilan',
            'kesehatan_ibu' => 'Kesehatan Ibu',
            'lainnya' => 'Lainnya',
            default => $this->kategori,
        };
    }

    /**
     * Get reading time in minutes
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->konten));
        return (int) ceil($words / 200); // Average 200 words per minute
    }

    /**
     * Get word count
     */
    public function getWordCountAttribute(): int
    {
        return str_word_count(strip_tags($this->konten));
    }

    /**
     * Get excerpt or auto-generate from konten
     */
    public function getExcerptOrGeneratedAttribute(): string
    {
        if (!empty($this->excerpt)) {
            return $this->excerpt;
        }

        $text = strip_tags($this->konten);
        return Str::limit($text, 200);
    }

    /**
     * Relationship: Penulis
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    /**
     * Scope: Published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at');
    }

    /**
     * Scope: Draft articles
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: By kategori
     */
    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope: Search
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('konten', 'like', "%{$search}%")
                ->orWhere('tags', 'like', "%{$search}%");
        });
    }

    /**
     * Scope: Popular (most viewed)
     */
    public function scopePopular($query, int $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    /**
     * Scope: Latest
     */
    public function scopeLatest($query, int $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Publish artikel
     */
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    /**
     * Unpublish artikel
     */
    public function unpublish(): void
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Archive artikel
     */
    public function archive(): void
    {
        $this->update([
            'status' => 'archived',
        ]);
    }

    /**
     * Increment views
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Check if published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    /**
     * Check if draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if archived
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }
}
