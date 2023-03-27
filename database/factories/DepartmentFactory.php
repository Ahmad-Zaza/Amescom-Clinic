<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;
    protected $array = [
        'داخلية',
        'عظمية',
        'هضمية',
        'اذن وحنجرة',
        'سنية',
        'قلبية',
        'جراحية',
        'مخبر أشعة',
        'مخبر تحاليل',
        'استقبال',
    ];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = random_int(0, 9);
        return [
            'admin_id' => 1,
            'name' => $this->array[$rand],
        ];
    }
}