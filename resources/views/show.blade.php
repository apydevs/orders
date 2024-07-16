<x-app-layout>
<div x-data="{ modalOpen: false,newDeliveryAddress: false }">
    <x-slot name="header">
        <div class="bg-indigo-700 pt-8 pb-16 relative ">
            <div class="container px-6 mx-auto flex flex-col lg:flex-row items-start lg:items-center justify-between">

                <div class="flex-col flex lg:flex-row items-start lg:items-center">
                    <div class="ml-0 lg:ml-0 my-6 lg:my-0">

                        <h4 class="text-2xl font-bold leading-tight text-white mb-2"> {{ __('Order')  }} {{$order->id}}</h4>
                        <p class="flex items-center text-gray-300 text-xs">
                            <a href="{{route('dashboard')}}">
                                <span class="cursor-pointer">CRM</span>
                            </a>
                            <span class="mx-2">&gt;</span>
                            <a href="{{route('orders.index')}}" >
                                <span class="cursor-pointer {{request()->routeIs('customers.index') ? 'font-semibold':''}}">Orders</span>
                            </a>
                            <span class="mx-2">&gt;</span>
                            <a href="#" >
                                <span class="cursor-pointer {{request()->routeIs('orders.show') ? 'font-semibold':''}}">Order No:{{$order->id}}</span>
                            </a>
                        </p>
                    </div>
                </div>





                <div class="flex flex-row">
                    <div>
                        <span class="text-white">{{$order->customer->full_name}}</span>  <button class="cursor-default focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full focus:ring-gray-400 mr-3 bg-transparent transition duration-150 ease-in-out rounded hover:bg-gray-700 text-white px-2 py-1 text-md border border-white">{{$order->customer_account_no}}</button>
                    </div>
                </div>
            </div>




        </div>
    </x-slot>

        <div class="container mx-auto grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 pt-6 gap-8">
            <!-- Remove class [ h-24 ] when adding a card block -->
            <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
            <div class="rounded ">



                <div class="sm:hidden relative w-11/12 mx-auto rounded">
                    <div class="absolute inset-0 m-auto mr-4 z-0 w-6 h-6">
                        <img class="icon icon-tabler icon-tabler-selector" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/active-inigo-svg1.svg" alt="selector" />
                    </div>
                    <select aria-label="Selected tab" class="form-select block w-full p-3 border border-gray-300 dark:border-gray-700 rounded text-gray-600 dark:text-gray-200 appearance-none bg-transparent relative z-10">
                        <option class="text-sm text-gray-600">Customer</option>
                        <option class="text-sm text-gray-600">Payment</option>
                        <option class="text-sm text-gray-600">Notes</option>
                    </select>
                </div>
                <div class="xl:w-full xl:mx-0 h-12 hidden sm:block bg-white dark:bg-gray-800 rounded shadow">
                    <div class="flex border-b px-5">
                        <button data-tab="tab1" onclick="activeTab(this)" class="hover:text-indigo-700 focus:text-indigo-700 focus:outline-none text-sm text-indigo-700 flex flex-col justify-between border-indigo-700 pt-3 rounded-t mr-8 font-normal cursor-pointer">
                            <span class="mb-3 dark:text-white ">Customer</span>
                            <div class="w-full h-1 bg-indigo-700 rounded-t-md"></div>
                        </button>
                        <button data-tab="tab4" onclick="activeTab(this)" class="hover:text-indigo-700 focus:text-indigo-700 focus:outline-none text-sm text-gray-600 flex flex-col justify-between border-indigo-700 pt-3 rounded-t mr-8 font-normal cursor-pointer">
                            <span class="mb-3 dark:text-white ">Payment</span>
                            <div class="w-full h-1 bg-indigo-700 rounded-t-md hidden"></div>
                        </button>
                        <button data-tab="tab5" onclick="activeTab(this)" class="hover:text-indigo-700 focus:text-indigo-700 focus:outline-none text-sm text-gray-600 flex flex-col justify-between border-indigo-700 pt-3 rounded-t mr-8 font-normal cursor-pointer">
                            <span class="mb-3 dark:text-white ">Notes</span>
                            <div class="w-full h-1 bg-indigo-700 rounded-t-md hidden"></div>
                        </button>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div id="tab1" class="tab-content bg-white/50">

                    <div class="w-full max-w-2xl px-4">
                        <div class="">
                            <div class="px-1 pt-6 overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <tbody>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td>
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Customer Number:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3">{{$customer->account_reference}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Full Name:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3"><a class="underline cursor-pointer" href="{{route('customers.show',$customer->id)}}">{{$customer->full_name}} </a> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">DOB:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3">{{\Carbon\Carbon::createFromFormat('Y-m-d',$customer->date_of_birth)->format('d M Y')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Email:</p>
                                                        <p class="text-black lowercase font-semibold  ml-3">{{$customer->email}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Contact Number:</p>
                                                        <p class="text-black lowercase font-semibold  ml-3">{{$customer->phone}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white top-0 ">Billing Address:</p>

                                                        <div class="flex flex-row justify-between">
                                                            <span class="text-black capitalize font-semibold text-wrap  ml-3 leading-6  w-full">{{nl2br($order->billing_address)}} </span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="py-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Delivery Address:</p>
                                                        <div class="flex flex-row justify-between">
                                                        <a  @click="newDeliveryAddress=true" class="text-black capitalize font-semibold text-wrap  ml-3 leading-6  cursor-pointer underline">{{nl2br($order->delivery_address)}} </a>
                                                            <svg @click="newDeliveryAddress=true" class="w5 h-5 ml-2" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="tab4" class="tab-content hidden bg-white/50" x-data="{changeCard : false}">
                    <div class="w-full  ">
                        <div x-show="!changeCard" class="">
                            <div class="px-1 py-6 overflow-x-auto">
                                <table class="w-full whitespace-nowrap ">
                                    <tbody>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td>
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">

                                                        <p class="text-gray-800 dark:text-white ">Transaction ID:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3">{{$order->translation_id}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">

                                                        <p class="text-gray-800 dark:text-white ">Payment Card ID:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3">{{$order->card_identifier}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Transaction Type:</p>
                                                        <p class="text-black capitalize font-semibold  ml-3">{{$order->transaction_type}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr tabindex="0" class="focus:outline-none">
                                        <td class="pt-6">
                                            <div class="flex items-center">
                                                <div class="pl-3" x-data="{show:false}">
                                                    <div class="flex items-center text-sm leading-none">
                                                        <p class="text-gray-800 dark:text-white ">Card:</p>

                                                        <p x-show="show" class="text-black capitalize font-semibold  ml-3">{{$cardDetails ? $cardDetails->card_type : ''}} {{$cardDetails ? $cardDetails->last_four:''}}</p>
                                                        <p x-show="!show" class="text-black capitalize font-semibold  ml-3">********** ***</p>
                                                        <div @click="show=!show">
                                                            <svg x-show="!show" data-slot="icon" class="h-5 w-5 ml-5" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                                            </svg>
                                                            <svg x-show="show" data-slot="icon" class="h-5 w-5 ml-5" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <button @click="changeCard =true" type="button" class=" ml-2 my-5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Change Card</button>

                            </div>
                        </div>
                        <div x-show="changeCard" class="">
                            <livewire:payment-card order="{{$order->id}}"/>
                        </div>
                    </div>


                </div>
                <div id="tab5" class="tab-content hidden bg-white/50 p-4 pb-16">
                    <livewire:notes usage="Order" :ref="$order"/>
                </div>





            </div>
            <!-- Remove class [ h-24 ] when adding a card block -->
            <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
            <div class="rounded ">
                <div>
                    <div class="flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Product</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($items as $item)
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$item->product_title}}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">£{{$order->isContract ? $item->price*156 :$item->price}}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$item->quantity}}</td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <form method="post" action="{{route('orders.ordered',$item->id)}}">
                                                        @csrf
                                                        <button class="text-indigo-600 hover:text-indigo-900">{{$item->dispatched ? 'Ordered':'Mark as Ordered'}} </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container pt-6 mx-auto">
            <div class="flex flex-wrap">
                <div class="md:w-1/5 w-full pb-6 md:pb-0 md:pr-6">
                    <!-- Remove class [ h-24 ] when adding a card block -->
                    <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
                    <div class="rounded  h-full">
                        <div class="mb-3">
                            <div class="max-w-sm rounded shadow bg-[{{$status['color']}}] dark:bg-gray-800 px-6 py-5" style="background-color: {{$status['color']}}">
                                <div class="sm:flex justify-center items-center h-full w-full">
                                    <div class="text-white text-center text-2xl uppercase flex flex-col">
                                        <span >{{$status['status']}} </span>
                                        <span class="text-sm capitalize">{{$dispatchStatus}} </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="max-w-sm rounded shadow bg-white dark:bg-gray-800 px-6 py-5">
                                <div class="sm:flex items-center h-full">
                                    <div>
                                        <p tabindex="0" class="focus:outline-none text-xl font-semibold leading-4 text-gray-800 dark:text-gray-100">Overview</p>
                                       <p tabindex="0" class="focus:outline-none text-xs leading-3 text-gray-500 dark:text-gray-400 pt-4 pb-1 capitalize">Current {{$order->payment_schedule}} Schedule</p>
                                        <p tabindex="0" class="focus:outline-none text-base font-medium leading-none text-gray-800 dark:text-gray-100">{{$current_schedule}} </p>
                                        <p tabindex="0" class="focus:outline-none text-xs leading-3 text-gray-500 dark:text-gray-400 pt-4 pb-1">Paid</p>
                                        <p tabindex="0" class="focus:outline-none text-base font-medium leading-none text-gray-800 dark:text-gray-100">£{{number_format($total_paid,2)}}</p>
                                        <p tabindex="0" class="focus:outline-none text-xs leading-3 text-gray-500 dark:text-gray-400 pt-4 pb-1">Payments On Time</p>
                                        <p tabindex="0" class="focus:outline-none text-base font-medium leading-none text-gray-800 dark:text-gray-100">{{$percentage}}%</p>
                                        <p tabindex="0" class="focus:outline-none text-xs leading-3 text-gray-500 dark:text-gray-400 pt-4 pb-1 capitalize">Created By {{$creator ? $creator->name :''}}</p>

                                    </div>
                                </div>
                            </div>
                        </div>







                    </div>
                </div>
                <div class="md:w-4/5 w-full">
                    <!-- Remove class [ h-24 ] when adding a card block -->
                    <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
                    <div class="rounded ">
                        <div>
                            <div class="flow-root">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Week Schedule</th>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Date:</th>

                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Attempt</th>
                                                    <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                @foreach($schedules as $schedule)

                                                    <tr>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">#{{$schedule->sequence_id}}</td>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$schedule->payment_schedule_date ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$schedule->payment_schedule_date)->format('d-m-Y') : ''}}</td>

                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">£{{$schedule->payable_amount}}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 capitalize">
                                                            {{$schedule->status}}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$schedule->payment_made_date ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$schedule->payment_made_date)->format('d-m-Y') : ''}}</td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                          @if($current_schedule == $schedule->sequence_id )
                                                            @if($schedule->payment_processed && $schedule->payment_made_date && !$schedule->retry_flag)
                                                                <button type="button" class="bg-green-700 cursor-default rounded-lg text-white px-3 py-0.5">
                                                                    Payment Collected
                                                                </button>

                                                            @elseif(!$schedule->payment_processed && $schedule->status =='failed' && $schedule->retry_flag)
                                                                <form method="post" action="{{route('schedule.payment',['order'=>$order,'schedule'=>$schedule->id])}}">
                                                                    @csrf

                                                                    <button type="submit" class="bg-red-600 hover:bg-red-800 rounded-lg text-white px-3 py-0.5">
                                                                        Failed Retry Payment
                                                                    </button>
                                                                </form>

                                                            @else
                                                                <div x-data="{clicked : false}">
                                                                    <form method="post" action="{{route('schedule.payment',['order'=>$order,'schedule'=>$schedule->id])}}">
                                                                        @csrf

                                                                        <button @click="clicked = true" x-show="!clicked" type="submit" class="bg-blue-600 hover:bg-blue-800 rounded-lg text-white px-3 py-0.5">
                                                                            Process Payment
                                                                        </button>
                                                                        <button  x-show="clicked" type="button" class="bg-blue-600 hover:bg-blue-800 rounded-lg text-white px-3 py-0.5">
                                                                            Processing please wait..
                                                                        </button>
                                                                    </form>
                                                                </div>



                                                            @endif
                                                              @else
                                                                @if($schedule->payment_processed && $schedule->payment_made_date && !$schedule->retry_flag)


                                                                        <button type="button" class="bg-green-700 cursor-default rounded-lg text-white px-3 py-0.5">
                                                                            Payment Collected
                                                                        </button>

                                                                @else
                                                                    @if($schedule->status !='pending' )
                                                                        <form method="post" action="{{route('schedule.payment',['order'=>$order,'schedule'=>$schedule->id])}}">
                                                                            @csrf

                                                                            <button type="submit" class="bg-red-600 hover:bg-red-800 rounded-lg text-white px-3 py-0.5">
                                                                                Failed Retry Payment
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                              @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <!-- More people... -->
                                                </tbody>
                                            </table>
                                            <div class="my-3 mx-5">
                                                {{$schedules->links()}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <div
        @keydown.escape.window="modalOpen = false"
        class="relative z-50 w-auto h-auto">
        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
                <div x-show="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen"
                     x-trap.inert.noscroll="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg">


                        <livewire:forms.order-address :order="$order" type="billing"/>

                </div>
            </div>
        </template>
    </div>

    <div
        @keydown.escape.window="newDeliveryAddress = false"
        class="relative z-50 w-auto h-auto">
        <template x-teleport="body">
            <div x-show="newDeliveryAddress" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
                <div x-show="newDeliveryAddress"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="newDeliveryAddress=false" class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                <div x-show="newDeliveryAddress"
                     x-trap.inert.noscroll="newDeliveryAddress"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg">



                        <livewire:forms.order-address :order="$order" type="delivery"/>

                </div>
                </div>
        </template>
    </div>
    <script type="text/javascript">
        function activeTab(element) {
            let siblings = element.parentNode.querySelectorAll("button");
            let tabContents = document.querySelectorAll(".tab-content");

            for (let item of siblings) {
                //item.children[0].innerHTML = "Inactive";
                item.children[1].classList.add("hidden");
                item.classList.add("text-gray-600");
                item.classList.remove("text-indigo-700");
            }

            // element.children[0].innerHTML = "Active";
            element.children[1].classList.remove("hidden");
            element.classList.remove("text-gray-600");
            element.classList.add("text-indigo-700");

            let activeTabId = element.getAttribute("data-tab");

            for (let content of tabContents) {
                if (content.id === activeTabId) {
                    content.classList.remove("hidden");
                } else {
                    content.classList.add("hidden");
                }
            }
        }

    </script>
</div>




</x-app-layout>
