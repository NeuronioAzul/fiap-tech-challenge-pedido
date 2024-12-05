<?php

namespace Database\Factories;

use TechChallenge\Infra\DB\Eloquent\Product\Model as Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define o estado padrão do modelo.
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 100), // Preço entre 10.00 e 100.00
        ];
    }
}
