<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * De velden die mass assignment toelaat.
     */
    protected $fillable = [
        'naam',
        'email',
        'adres',
        'woonplaats',
        'telefoonnummer',
    ];
}
