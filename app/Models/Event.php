<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
    'organization_id',
    'category_id',
    'title',
    'description',
    'date',
    'location',
    'price',
    'stock',
    'poster_path',
];
    /**
 * Organisasi penyelenggara event.
 */
public function organization(): BelongsTo
{
    return $this->belongsTo(Organization::class);
}
    /**
     * Relasi ke kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke transaksi.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi ke review.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Rata-rata rating event.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Total review event.
     */
    public function totalReviews()
    {
        return $this->reviews()->count();
    }
}