<?php

namespace Apydevs\Orders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentSchedule extends Model
{
    use HasFactory;


    public function order(){

        return $this->belongsTo(Order::class,'id','order_id');
    }
}
