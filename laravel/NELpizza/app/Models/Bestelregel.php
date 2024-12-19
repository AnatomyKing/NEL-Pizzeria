<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bestelregel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aantal',
        'afmeting',
        'pizza_id',
        'bestelling_id',
        'bestelling_pizza_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pizza_id' => 'integer',
        'bestelling_id' => 'integer',
        'bestelling_pizza_id' => 'integer',
    ];

    public function bestellingPizza(): BelongsTo
    {
        return $this->belongsTo(BestellingPizza::class);
    }

    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }

    public function bestelling(): BelongsTo
    {
        return $this->belongsTo(Bestelling::class);
    }
}
