<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
    ];

    /**
     * Relasi ke user (Organizer/Panitia).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke event yang dimiliki organisasi.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}