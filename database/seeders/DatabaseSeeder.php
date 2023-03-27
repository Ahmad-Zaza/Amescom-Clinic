<?php

namespace Database\Seeders;

use Faker\Provider\Medical;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            DepartmentSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            ReceptionistSeeder::class,
            VisitingSeeder::class,
            MedicalPersonSeeder::class,
            RequestSeeder::class,
        ]);
    }
}