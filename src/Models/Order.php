<?php

namespace Apydevs\Orders\Models;

use App\Models\GatewayReference;
use App\Models\MobileDetail;
use App\Models\Note;
use App\Models\Scopes\DynamicLikeScope;
use App\Models\Scopes\IlikeScope;
use App\Models\User;
use Apydevs\Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    use HasFactory;

    protected $with = ['notes'];
    protected $fillable = [
        'customer_id',
        'customer_account_no',
        'billing_address',
        'delivery_address',
        'total_price',
        'status',
        'payment_schedule',
        'duration',
        'payment_method',
        'translation_id',
        'card_identifier',
        'gateway_status_code',
        'gateway_status',
        'transaction_type',
        'gateway_total_amount',
        'notes',
        'team_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'postal_code',
        'current_schedule',
        'dispatch_status',
        'user_id'
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DynamicLikeScope);
    }

    /**
 * Requires Customers Module
 * ApyDevs/customers
 * @return BelongsTo
 */

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function paymentSchedule()
    {
        return $this->hasMany(OrderPaymentSchedule::class,'order_id','id');
    }

    public function currentPaymentSchedule(){
        return $this->hasMany(OrderPaymentSchedule::class,'order_id','id')->whereNull('payment_made_date')->orderBy('sequence_id','ASC');
    }

    public function paymentsMade(){
        return $this->hasMany(OrderPaymentSchedule::class,'order_id','id')->whereNotNull('payment_made_date')->orderBy('sequence_id','ASC');
    }


    public function getCurrentPaymentSchedule()
    {
        return $this->hasOne(OrderPaymentSchedule::class, 'order_id', 'id')
            ->limit(1)
            ->orderBy('sequence_id', 'ASC')
            ->where(function ($query) {
                $query->whereNull('gateway_status')
                    ->orWhere('gateway_status', '!=', '0000');
            });
    }


        public function paymentRef(): \Illuminate\Database\Eloquent\Relations\HasOne
        {
            return $this->hasOne(GatewayReference::class,'card_identifier','card_identifier');
        }

    /**
     * Get all the Order notes.
     * @return MorphMany
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable');
    }


    public function contractOrder(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MobileDetail::class, 'order_id', 'id');
    }

}
