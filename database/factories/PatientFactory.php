<?php

namespace Database\Factories;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->firstNameMale(),
            'lastName' => $this->faker->lastName(),
            'fatherName' => $this->faker->firstNameMale(),
            'nationaltyID' => $this->faker->randomNumber(),
            'nationaltyID' => 31232131251545,
            'phoneNumber' => '213123123',
            'gender' => 'male',
            'bloodSympol' => $this->faker->bloodGroup(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}