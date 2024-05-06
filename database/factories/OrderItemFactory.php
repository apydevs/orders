<?php

namespace Apydevs\Orders\Database\Factories;

use Apydevs\Orders\Models\Order;
use Apydevs\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Apydevs\Orders\Models\Model>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {




        return [
            'order_id' => Order::factory()->create()->id,
            'product_id' => Product::factory()->create()->id, // Ensure you have a Product model and factory
            'quantity' => 1,
            'price' => $this->faker->randomFloat(2, 20, 500), // Price before discount
            'vat_rate' => $this->faker->randomElement([5, 10, 20]), // VAT rate percentage
            'vat' => 0,
            'product_description' => $this->faker->paragraph, // Description of the order item
            'product_title' => $this->faker->company, // Description of the order item
        ];

    }
}
