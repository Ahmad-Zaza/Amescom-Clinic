<?php

namespace Database\Seeders;

use App\Models\Visiting;
use Illuminate\Database\Seeder;

class VisitingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visiting::factory()->count(50)->create();
    }
}
