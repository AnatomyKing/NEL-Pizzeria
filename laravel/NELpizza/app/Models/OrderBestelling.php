<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBestelling extends Model
{
    use HasFactory;

    protected $table = 'bestellings'; // The actual table name in the database

    public function bestelregels()
    {
        return $this->hasMany(OrderBestelregel::class, 'bestelling_id'); // Foreign key
    }
}
