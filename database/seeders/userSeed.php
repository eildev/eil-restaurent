<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'EBB',
            'email' => 'ebb@gmail.com',
            'phone' => '12345656',
            'branch_id' =>1,
            'password' => Hash::make('123'),
        ]);
    }
}
