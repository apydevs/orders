<?php

namespace Apydevs\Orders\Database\Seeders;

use Apydevs\Customers\Models\Customer;
use Apydevs\Orders\Models\Order;
use Apydevs\Orders\Models\OrderItem;
use Apydevs\Orders\Models\OrderPaymentSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Order::factory()->count(3)
            ->has(OrderItem::factory()->count(1))
            ->has(OrderPaymentSchedule::factory(12))
            ->create();
    }
}
