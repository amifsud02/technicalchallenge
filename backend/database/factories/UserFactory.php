<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'address1' => fake()->address(),
            'address2' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'postcode' => fake()->postcode()
        ];
    }
}


// • First Name (string) << Mandatory
// • Surname (string) << Mandatory
// • Email (string) << Mandatory
// • Phone Number (longint) << Mandatory
// • Address 1 (string) << Mandatory
// • Address 2 (optional) (string)
// • City << Mandatory (string)
// • State (optional) (string) << If US is selected it populated US States in the dropdown
// • Country (string) << From dropdown
// • Postcode (optional) (string)