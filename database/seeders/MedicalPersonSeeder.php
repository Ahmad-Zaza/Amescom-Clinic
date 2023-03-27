<?php

namespace Database\Seeders;

use App\Models\MedicalPerson;
use Illuminate\Database\Seeder;

class MedicalPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalPerson::factory()->count(20)->create();
    }
}
