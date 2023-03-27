<?php

namespace Database\Factories;

use App\Models\MedicalPerson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MedicalPersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicalPerson::class;

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
        $array = ['doctor', 'radiograph', 'analysis'];
        $rand = rand(0, 2);
        $depRand = rand(1, 10);
        return [
            'department_id' => $depRand,
            'admin_id' => 1,
            'firstName' => $firstName,
            'fatherName' => $this->faker->firstNameMale(),
            'lastName' => $lastName,
            'phoneNumber' => $this->faker->phoneNumber(),
            'aboutYou' => $this->faker->text(),
            'userName' => $firstName . '_' . $lastName . '_' . $randStr,
            'password' => Hash::make('123456'),
            'isContracted' => 1,
            'type' => $array[$rand],
        ];
    }
}