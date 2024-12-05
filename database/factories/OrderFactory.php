<?php

namespace Database\Factories;

use TechChallenge\Infra\DB\Eloquent\Order\Model as Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define o estado padrão do modelo.
     */
    public function definition()
    {
        return [
            'status' => 'pending',
            'total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
