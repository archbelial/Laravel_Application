<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'CODE' => $this->faker->unique()->randomNumber(5),
            'NAME' => $this->faker->name,
            'GENDER' => $this->faker->randomElement(['Male', 'Female']),
            'POSITION' => $this->faker->jobTitle,
            'LEVEL' => $this->faker->randomElement(['Staff', 'Manager', 'Senior Manager']),
            'LEAVE_DAYS' => $this->faker->numberBetween(4, 12),
        ];
    }
}
