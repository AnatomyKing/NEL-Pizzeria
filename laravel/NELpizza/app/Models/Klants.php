<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class klants extends Model
{
    use HasFactory;

    protected $table = 'klants'; // Correcte tabelnaam

    protected $fillable = [
        'naam',
        'adres',
        'woonplaats',
        'telefoonnummer',
        'emailadres',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'klant_id');
    }
}


