<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'logo_url',
    ];

    /**
     * Partner dimiliki oleh satu organisasi.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}