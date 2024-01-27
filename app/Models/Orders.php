<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $guarded=[];


    /**
     * Get the user associated with the Orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderDetail()
    {
        return $this->hasOne(OrderDetails::class, 'order_id', 'id');
    }    
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
