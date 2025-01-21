<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBestelregel extends Model
{
    use HasFactory;

    protected $table = 'bestelregels'; // The actual table name in the database

    public function bestelling()
    {
        return $this->belongsTo(OrderBestelling::class, 'bestelling_id'); // Foreign key
    }
}
