<?php

namespace App\Models\Product;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'product_name',
        'product_code',
        'product_price',
        'created_at',
    ];

    public function productOrders()
    {
        return $this->hasMany(Order::class);
    }
}
