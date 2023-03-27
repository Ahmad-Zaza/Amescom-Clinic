<?php

namespace Database\Factories;

use App\Models\Visiting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VisitingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visiting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id' => rand(1, 20),
            'department_id' => rand(1, 7),
            'receptionist_id' => rand(1, 20),
        ];
    }
}