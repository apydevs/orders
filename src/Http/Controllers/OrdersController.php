<?php

namespace Apydevs\Orders\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Apydevs\Orders\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{


    public function index(){

        return view('orders::index',[
            'count'=>Order::count()
            ]);
    }


}
