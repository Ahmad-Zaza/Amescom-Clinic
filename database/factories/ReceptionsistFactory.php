<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Receptionsist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReceptionsistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receptionsist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstNameMale();
        $lastName = $this->faker->lastName();
        $randStr = Str::random(3);
        return [
            'department_id' => 10,
            'admin_id' => 1,
            'firstName' => $firstName,
            'fatherName' => $this->faker->firstNameMale(),
            'lastName' => $lastName,
            'phoneNumber' => $this->faker->phoneNumber(),
            'aboutYou' => $this->faker->text(),
            'userName' => $firstName . '_' . $lastName . '_' . $randStr,
            'password' => Hash::make('123456'),
            'isContracted' => 1
        ];
    }
}