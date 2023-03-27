<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'firstName' => 'ahmad',
            'fatherName' => 'emad',
            'lastName' => 'zaza',
            'userName' => 'zaza98',
            'password' => Hash::make('123456'),
            'avatar' => 'sdfdsf',
        ]);
    }
}