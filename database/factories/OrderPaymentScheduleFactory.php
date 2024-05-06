<?php

namespace Apydevs\Orders\Database\Factories;

use Apydevs\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Apydevs\Orders\Models\Model>
 */
class OrderPaymentScheduleFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_take_date' => $this->faker->date('Y-m-d', '+1 month'), // Assuming payments are scheduled for the future
            'payment_due_date' => $this->faker->date('Y-m-d', '+1 month'), // Similar to payment_take_date but might be adjusted based on business logic
            'payment_processed' => $this->faker->boolean,
            'amount_due' => $this->faker->randomFloat(2, 50, 1000), // Amount that is due
            'amount_paid' => function (array $attributes) {
                // Assuming amount_paid is similar to amount_due if payment is processed and status is completed
                return $attributes['payment_processed'] && $attributes['status'] === 'completed' ? $attributes['amount_due'] : 0;
            },
            'billing_cycle' => $this->faker->randomElement(['weekly', 'bi-weekly', 'monthly', 'annually']), // Frequency of the billing
        ];
    }
}
