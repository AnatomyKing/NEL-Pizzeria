<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naam',
        'adres',
        'woonplaats',
        'telefoonnummer',
        'emailadres',
    ];

    public function bestellings(): HasMany
    {
        return $this->hasMany(Bestelling::class);
    }
}
