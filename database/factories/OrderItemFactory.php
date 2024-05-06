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
            'order_id' => Order::factory(),
            'product_id' => Product::factory(), // Ensure you have a Product model and factory
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 20, 500), // Price before discount
            'discount' => $this->faker->numberBetween(0, 100), // Discount in percentage
            'description' => $this->faker->paragraph, // Description of the order item
            'total_price' => function (array $attributes) {
                // Calculates total price after discount
                return $attributes['price'] * (1 - ($attributes['discount'] / 100)) * $attributes['quantity'];
            }
        ];

    }
}
