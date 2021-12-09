<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->seqNumber(),
            'name' => $this->faker->name(),
            'tel' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'company' => $this->faker->company(),
            'user_name' => $this->faker->userName(),
            'country' => $this->faker->country(),
            'element' => $this->faker->randomElement(['男', '女']),
            'birth' => $this->faker->date('Y/m/d', 'now'),
            'comment' => $this->faker->text(),
        ];
    }

    private $num = 1;
    public function seqNumber()
    {
        return strval($this->num++);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    /*
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
*/
}
