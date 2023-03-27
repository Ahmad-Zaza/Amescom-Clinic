<?php

namespace Database\Seeders;

use App\Models\Receptionsist;
use Illuminate\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Receptionsist::factory()->count(20)->create();
    }
}
