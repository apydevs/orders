<?php

namespace Apydevs\Orders\Models;

use Apydevs\Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;


    /**
     * Requires Customers Module
     * ApyDevs/customers
     * @return BelongsTo
     */
    public function customer(){
        return $this->belongsTo(Customer::class,'id');
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function orderPaymentSchedule()
    {
        return $this->hasMany(OrderPaymentSchedule::class,'order_id','id');
    }

}
