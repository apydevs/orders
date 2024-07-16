<?php

namespace Apydevs\Orders\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\GatewayReference;
use App\Policies\PaymentGatewayPolicy;
use App\Traits\Opayo;
use App\Traits\OrderStatusTrait;
use Apydevs\Orders\Models\Order;
use Apydevs\Orders\Models\OrderItem;
use Apydevs\Orders\Models\OrderPaymentSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{

    use Opayo;
    use OrderStatusTrait;

    public function index(){

        return view('orders::index',[
            'count'=>Order::count(),
            'failedPayments'=>OrderPaymentSchedule::where('retry_flag',true)->count()
            ]);
    }


    public function show(Order $order){


      return  view('orders::show',[
            'total_paid'=>$order-> paymentsMade()->sum('payable_amount'),
            'percentage'=>$this->calculateOnTimePaymentPercentage($order->id),
            'current_schedule'=>$order->currentPaymentSchedule()->first()->sequence_id ?? '-',
            'status'=>$this->orderStatus($order->status),
            'dispatchStatus'=>$order->dispatch_status,
            'order'=>$order,
            'items'=>$order->orderItems()->get() ,
            'schedules'=>$order->paymentSchedule()->orderBy('sequence_id','ASC')->paginate(6),
            'customer'=>$order->customer,
            'creator'=>$order->user,
            'cardDetails'=>GatewayReference::where('card_identifier',mb_strtoupper($order->card_identifier))->first(),
      ]);
    }

    public function ordered(OrderItem $OrderItem){



        $OrderItem->dispatched =  !$OrderItem->dispatched;
        $OrderItem->save();
        $this->orderStatusBasedOnDispatchedItems($OrderItem->order_id);

        toast()
            ->success('Order Item Updated')
            ->pushOnNextPage();
        return redirect()->back();
    }



    public function process(Order $order, Request $request){



        $paymentGatewayPolicy = new PaymentGatewayPolicy();

        $order->translation_id;
        $order->card_identifier;
        $current = $order->getCurrentPaymentSchedule;
        $customer = $order->customer;
        $sessionKey =  $paymentGatewayPolicy->merchantSessionKey();
        $date = Carbon::now()->format('dmYHis');


        $data = [
            "transactionType" => "Authorise",
            "amount" =>round($current->payable_amount*100,1),
            "currency" => "GBP",
            "description" => "Trust Shopping Transaction",
            "customerFirstName" => $customer->first_name,
            "customerLastName" => $customer->last_name,
            "paymentMethod" => [
                "card" => [
                    "merchantSessionKey" => $sessionKey['merchantSessionKey'],
                    "cardIdentifier" => $order->card_identifier,
                    "reusable" => false,
                    "save" => false
                ]
            ],
            "credentialType" => [
                "cofUsage" => "Subsequent",
                "initiatedType" => "MIT",
                "mitType" => "Instalment",

                "recurringExpiry" => "20241224",
                "recurringFrequency" => "28",
                "purchaseInstalData" => "6"

            ],

            "referenceTransactionId" => $order->translation_id,
            "vendorTxCode" => "$current->order_id-$current->schedule_id-$date",
            "billingAddress" => [
                "address1" => $order->address_line1,
                "city" =>  $order->city,
                "postalCode" =>  $order->postal_code,
                "country" => "GB"
            ]
        ];

       $transactions = $paymentGatewayPolicy->transaction('transactions',$data);




        if($transactions['status'] == 'error' || isset($transactions['detials'])){

            $scheduleUpdate = OrderPaymentSchedule::findOrFail($current->id);
            $scheduleUpdate->payment_processed = false;
            $scheduleUpdate->status ='failed';
            $scheduleUpdate->retry_flag = true;
            $scheduleUpdate->payment_made_date = Carbon::now();
            $scheduleUpdate->cardIdentifier_id = $order->card_identifier;

            $scheduleUpdate->gateway_status = array_key_exists('statusCode',$transactions['details'])  ? $transactions['details']['statusCode'] : $transactions['details']['code'] ;
            $scheduleUpdate->gateway_ref = array_key_exists('statusDetail',$transactions['details'])  ? $transactions['details']['statusDetail'] : $transactions['details']['description'] ;

            $scheduleUpdate->update();


// Convert payment_schedule_date to a Carbon instance with the correct format
            $paymentScheduleDate = Carbon::createFromFormat('Y-m-d H:i:s', $current->payment_schedule_date)->startOfDay();
            $now = Carbon::now()->startOfDay();
            if ($current->sequence_id == 1) {
                $order->status = 'Failed P1';
            } elseif ($current->sequence_id >= 1 && $paymentScheduleDate->equalTo($now)) {
                $order->status = 'Payment Overdue';
            } elseif ($current->sequence_id >= 1 && $paymentScheduleDate->greaterThan($now)) {
                $order->status = 'Failed P' . $current->sequence_id;
            } else {
                $order->status = 'Lapsed';
            }
            $order->current_schedule = $current->sequence_id;
            $order->save();



            DB::table('payment_failed_log')->insert([
                'order_id'=>$order->id,
                'schedule_id'=>$scheduleUpdate->id
            ]);
            $order->notes()->create([
               'body'=>Carbon::now()->format('D M Y').' Status:'.$current->gateway_status.' Reason:'.$current->gateway_ref ,
              'name'=>Auth::user()->name

            ]);
            toast()
                ->warning('Payment Failed')
                ->pushOnNextPage();
            return redirect()->back();
        }else{
            $scheduleUpdate = OrderPaymentSchedule::findOrFail($current->id);
            $scheduleUpdate->payment_processed = true;
            $scheduleUpdate->retry_flag = false;
            $scheduleUpdate->status ='complete';
            $scheduleUpdate->payment_made_date = Carbon::now();
            $scheduleUpdate->transaction_id = $transactions['transactionId'];
            $scheduleUpdate->cardIdentifier_id = $order->card_identifier;
            $scheduleUpdate->gateway_status = $transactions['statusCode'];
            $scheduleUpdate->gateway_ref =$transactions['retrievalReference'];
            $scheduleUpdate->update();



        }


        if($current->sequence_id >= 1 && $scheduleUpdate->payment_processed){
            $order->current_schedule = $scheduleUpdate->sequence_id+1;
            $order->status = 'active';
            $order->update();
        }
        $this->removeFromFailedLog($order->id,$scheduleUpdate->sequence_id);
        $this->checkForCompletedOrder($order->id);
      //  dd($order,$current,$transactions,$scheduleUpdate);
        toast()
            ->success('Payment Processed')
            ->pushOnNextPage();

        return redirect()->back();


    }




    private function orderStatus($status){

        switch ($status){

            case 'active':
            case 'pre-dispatched':
            case 'part-dispatched':
            case 'post-dispatched':

            return [
                    'color'=>'#2563eb',
                    'status'=>$status
                ];
            case 'pending-p1':
            return [
                'color'=>'#fb923c',
                'status'=>$status
            ];
            case 'Failed-P1':
                return [
                    'color'=>'#EE4B2B',
                    'status'=>$status
                ];
            case 'payment-overdue':
            case 'lapsed':
            case 'chargeback':
            case 'Defaulted':
                return [
                    'color'=>'#ef4444',
                    'status'=>$status
                ];

            case 'complete':
                return [
                        'color'=>'#22c55e',
                    'status'=>$status
                ];



            default:
                return [
                    'color'=>'#fb923c',
                    'status'=>$status
                ];
        }

        }


    private function calculateOnTimePaymentPercentage($orderId) {
        // Fetch payment schedules for the given order ID
        $paymentSchedules = OrderPaymentSchedule::where('order_id', $orderId)
            ->whereNotNull('payment_made_date')
            ->get();

        // Initialize counters
        $onTimeCount = 0;
        $totalPayments = $paymentSchedules->count();

        // Log total payments for debugging
        \Log::info("Total Payments with Payment Made Date: " . $totalPayments);

        // Calculate the number of on-time payments
        foreach ($paymentSchedules as $schedule) {
            // Log each schedule for debugging
            \Log::info("Schedule ID: " . $schedule->id . ", Payment Made Date: " . $schedule->payment_made_date . ", Payment Schedule Date: " . $schedule->payment_schedule_date);

            // Check if both dates are not null
            if (!is_null($schedule->payment_made_date) && !is_null($schedule->payment_schedule_date)) {
                // Convert dates to Carbon instances for comparison
                $paymentMadeDate = \Carbon\Carbon::parse($schedule->payment_made_date)->startOfDay();
                $paymentScheduleDate = \Carbon\Carbon::parse($schedule->payment_schedule_date)->startOfDay();

                // Log the comparison result for debugging
                \Log::info("Comparing: " . $paymentMadeDate->toDateString() . " <= " . $paymentScheduleDate->toDateString());

                // Compare the dates
                if ($paymentMadeDate->lessThanOrEqualTo($paymentScheduleDate)) {
                    $onTimeCount++;
                } else {
                    \Log::info("Late Payment Detected: Schedule ID: " . $schedule->id);
                }
            }
        }

        // Log on-time payments for debugging
        \Log::info("On-Time Payments: " . $onTimeCount);

        // Calculate the percentage of on-time payments
        $percentageOnTime = $totalPayments > 0 ? ($onTimeCount / $totalPayments) * 100 : 0;

        // Log the percentage for debugging
        \Log::info("Percentage On-Time: " . $percentageOnTime);

        return number_format($percentageOnTime, 2);
    }





    private function checkForCompletedOrder($orderId){

        $scheduleUpdate = OrderPaymentSchedule::where('order_id',$orderId)->get();
        $total =    $scheduleUpdate->count();
        $totalProcessed  =    $scheduleUpdate->where('payment_processed',true)->count();
        $totalFailed  =    $scheduleUpdate->where('payment_processed',false)->where('retry_flag',true)->count();

        if($totalProcessed == $total && $totalFailed == 0){
            $order =  Order::findOrFail($orderId);
            $order->status = 'complete';
            $order->save();
        }
    }


    private function removeFromFailedLog($orderId,$scheduleUpdateId){

        DB::table('payment_failed_log')->delete([
            'order_id'=>$orderId,
            'schedule_id'=>$scheduleUpdateId
        ]);

    }
}
