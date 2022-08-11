<?php

namespace App\Models\Customer;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_phone',
        'created_at',
    ];

    public function customerOrders()
    {
        return $this->hasMany(Order::class);
    }
}
