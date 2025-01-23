<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'naam',
        'functie',       // Toegevoegd
        'email',
        'adres',
        'woonplaats',
        'telefoon',      // Toegevoegd
    ];
}
