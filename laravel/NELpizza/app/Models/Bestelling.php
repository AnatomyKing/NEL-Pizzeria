<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bestelling extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datum',
        'status',
        'klant_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datum' => 'timestamp',
        'klant_id' => 'integer',
    ];

    public function klant(): BelongsTo
    {
        return $this->belongsTo(Klant::class);
    }

    public function bestelregels(): HasMany
    {
        return $this->hasMany(Bestelregel::class);
    }
}
