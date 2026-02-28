<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Billing;
use App\Models\User;

class Order extends Model
{
    protected $table = 'orders';

        protected $primaryKey = 'order_id';

        public $incrementing = true;

        protected $keyType = 'int';

        protected $fillable = [
            'user_id',
            'order_no',
            'status',
            'payment_mode',
            'total'
        ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}