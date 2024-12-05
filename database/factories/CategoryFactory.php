<?php

namespace Database\Factories;

use TechChallenge\Infra\DB\Eloquent\Category\Model as Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define o estado padrão do modelo.
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(), // Gera um nome fictício para a categoria
        ];
    }
}
