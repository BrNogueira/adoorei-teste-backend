<?php

namespace Database\Factories;

use App\Models\Mobile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MobileFactory extends Factory
{
    protected $model = Mobile::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->company,
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
