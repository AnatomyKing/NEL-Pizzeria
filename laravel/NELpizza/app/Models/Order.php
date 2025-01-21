<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Add the table name if it doesn't match "orders"
    protected $table = 'orders';

    // Specify any fillable fields if needed
    protected $fillable = ['customer_name', 'pizza_type', 'quantity', 'total_price', 'status']; // Replace with actual column names
}
