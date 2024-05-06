<x-app-layout>
    <x-slot name="header">
        <div class="bg-gray-800 pt-8 pb-16 relative ">
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
                <div class="flex flex-row">
                    <div>
                        <span class="text-white">Total Orders:</span>  <button class="cursor-default focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full focus:ring-gray-400 mr-3 bg-transparent transition duration-150 ease-in-out rounded hover:bg-gray-700 text-white p-2 text-sm border border-white">{{$count}}</button>
                    </div>
                </div>
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
                    Table
                </div>
            </div>

        </div>



        <x-slideover.left>
       Order Information
        </x-slideover.left>


    </div>
</x-app-layout>

