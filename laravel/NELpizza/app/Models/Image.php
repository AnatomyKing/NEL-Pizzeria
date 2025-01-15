<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['pizza_id', 'data', 'mime_type'];

    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }
}