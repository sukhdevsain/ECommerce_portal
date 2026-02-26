<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'order_id',
        'image',
        'name',
        'price',
        'qty',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
