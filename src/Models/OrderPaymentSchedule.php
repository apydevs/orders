<?php

namespace Apydevs\Orders\Models;

use App\Models\Scopes\DynamicLikeScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentSchedule extends Model
{
    use HasFactory;
    protected $table = 'payment_schedules';
    protected $guarded =[];


    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class,'id');
    }


}
