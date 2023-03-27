<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 7; $i++) {
            Department::create([
                'admin_id' => 1,
                'name' => $this->array[$i],
                'type' => 'doctor',
            ]);
        }
        for ($i = 7; $i < 9; $i++) {
            Department::create([
                'admin_id' => 1,
                'name' => $this->array[$i],
                'type' => 'laboratory',
            ]);
        }
        Department::create([
            'admin_id' => 1,
            'name' => 'استقبال',
            'type' => 'reception',
        ]);
    }
}