<x-app-layout>
    <x-slot name="header">
        <div class="bg-indigo-700 pt-8 pb-16 relative ">
            <div class="container px-6 mx-auto flex flex-col lg:flex-row items-start lg:items-center justify-between">

                <div class="flex-col flex lg:flex-row items-start lg:items-center">
                    <div class="ml-0 lg:ml-0 my-6 lg:my-0">
                        <h4 class="text-2xl font-bold leading-tight text-white mb-2">{{ __('Orders') }}</h4>
                        <p class="flex items-center text-gray-300 text-xs">
                            <a href="{{route('dashboard')}}">
                                <span class="cursor-pointer">CRM</span>
                            </a>
                            <span class="mx-2">&gt;</span>
                            <a href="{{route('orders.index')}}" >
                                <span class="cursor-pointer {{request()->routeIs('customers.index') ? 'font-semibold':''}}">Orders</span>
                            </a>
                        </p>
                    </div>
                </div>


                <ul role="list" class="lg:ml-auto grid grid-cols-1 gap-5 sm:grid-cols-1 sm:gap-6 lg:grid-cols-3 ">

                        <li x-data="{
        dropdownOpen: false
    }" class="col-span-1  col-end-6 flex rounded-md shadow-sm relative">
                            <div class="flex w-16 flex-shrink-0 items-center justify-center bg-red-600 rounded-l-md text-sm font-medium text-white">FO</div>
                            <div class=" flex flex-1 items-center justify-between  truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                                <div class="flex-1 truncate px-4 py-2 text-sm">
                                    <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Failed Payments</a>
                                    <p class="text-gray-500">{{$failedPayments}}</p>
                                </div>
                                <div class="flex-shrink-0 pr-2">
                                    <button @click="dropdownOpen=true" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span class="sr-only">Open options</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div x-show="dropdownOpen"
                                     @click.away="dropdownOpen=false"
                                     x-transition:enter="ease-out duration-200"
                                     x-transition:enter-start="-translate-y-2"
                                     x-transition:enter-end="translate-y-0"
                                     class="absolute top-0 z-50 w-56 mt-12 -translate-x-1/2 left-1/2"
                                     x-cloak>
                                    <div class="p-1 mt-1 bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                        <div class="px-2 py-1.5 text-sm font-semibold">Payment Actions</div>
                                        <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                                        <a href="#_" class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            <span>View Failed</span>
                                            <span class="ml-auto text-xs tracking-widest opacity-60"></span>
                                        </a>
                                        <a href="{{route('process.payments')}}"  class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                                            <span>Run Again</span><span class="ml-auto text-xs tracking-widest opacity-60"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </li>
                    </ul>


{{--                <div class="flex flex-row">--}}

{{--                    <div class="flex flex-col">--}}
{{--                    <div>--}}
{{--                        <span class="text-white">Ready To Ship: </span>--}}
{{--                        <button class="cursor-default focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full focus:ring-gray-400 mr-3 bg-transparent transition duration-150 ease-in-out rounded hover:bg-gray-700 text-white px-2 py-1 text-md border border-white">{{$count}}</button>--}}
{{--                    </div>--}}
{{--                    <span class="text-sm text-white">based on payment schedule. </span>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <span class="text-white">Total Orders:</span>  <button class="cursor-default focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full focus:ring-gray-400 mr-3 bg-transparent transition duration-150 ease-in-out rounded hover:bg-gray-700 text-white px-2 py-1 text-md border border-white">{{$count}}</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

    </x-slot>

    <div x-data="{ slideOverOpen: false}" class="pb-12">

        <div>
            <!-- Page title starts -->
            <!-- Page title ends -->
            <div class="container px-6 mx-auto">
                <!-- Remove class [ h-64 ] when adding a card block -->
                <div class="rounded shadow relative bg-white z-10 -mt-8 mb-8 w-full  p-4">
                   <livewire:orders::orders-table/>
                </div>
            </div>

        </div>



        <x-slideover.left>
       Order Information
        </x-slideover.left>


    </div>
</x-app-layout>

