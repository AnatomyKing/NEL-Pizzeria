<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Correcte tabelnaam

    protected $fillable = [
        'bestelling_datum',
        'status',
        'klant_id',
    ];

    public function klant()
    {
        return $this->belongsTo(Klant::class, 'klant_id');
    }
}

