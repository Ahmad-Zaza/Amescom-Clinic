<?php

namespace Database\Seeders;

use App\Models\DepartmentRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 7; $i++) {
            DepartmentRequest::create([
                'visiting_id' => $i,
            ]);
        }
    }
}