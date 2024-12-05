<?php

namespace Database\Factories;

use TechChallenge\Infra\DB\Eloquent\Customer\Model as Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid, // Gerar UUIDs para IDs únicos
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->numerify('###########'), // CPF fictício
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
