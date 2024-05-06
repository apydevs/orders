<?php

namespace Apydevs\Orders\Database\Factories;

use Apydevs\Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Apydevs\Orders\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $customer  = Customer::all()->take(1);
        return [
            'customer_id' =>$customer->id,
            'customer_account_no' => $customer->customer_account_no, // Generates an account number with format ACCT1234
            'total' => $this->faker->numberBetween(100, 1000), // General total cost of the order
            'total_price' => $this->faker->randomFloat(2, 100, 1000), // Total price after including VAT
            'vat_rate' => $this->faker->randomElement([5, 10, 20]), // VAT rate percentage
            'vat' => function (array $attributes) {
                // Calculates VAT based on the total_price and vat_rate
                return ($attributes['total_price'] * ($attributes['vat_rate'] / 100));
            },
            'billing_address' => $this->faker->address,
            'delivery_address' => $this->faker->address,
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_schedule' => $this->faker->randomElement(['one_time', 'weekly', 'bi-weekly', 'monthly']),
            'duration' => $this->faker->numberBetween(1, 12), // Duration in months
            'notes' => $this->faker->sentence
        ];
    }
}
