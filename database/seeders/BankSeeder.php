<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'id' => 1,
                'name' => 'Cash',
                'branch_name' => 'Dhaka',
                'manager_name' => 'No Name',
                'phone_number' => '0111113333',
                'account' => '343535',
                'email' => 'demo@gmail.com',
                'opening_balance' => '00',
                'purpose' => 'Cash',
            ],
            [
                'id' => 2,
                'name' => 'bKash',
                'branch_name' => 'Dhaka',
                'manager_name' => 'No Name',
                'phone_number' => '0111113333',
                'account' => '343535',
                'email' => 'demo@gmail.com',
                'opening_balance' => '00',
                'purpose' => 'bKash',
            ],
            [
                'id' => 3,
                'name' => 'Nagad',
                'branch_name' => 'Dhaka',
                'manager_name' => 'No Name',
                'phone_number' => '0111113333',
                'account' => '343535',
                'email' => 'demo@gmail.com',
                'opening_balance' => '00',
                'purpose' => 'Nagad',
            ],
            [
                'id' => 4,
                'name' => 'Rocket',
                'branch_name' => 'Dhaka',
                'manager_name' => 'No Name',
                'phone_number' => '0111113333',
                'account' => '343535',
                'email' => 'demo@gmail.com',
                'opening_balance' => '00',
                'purpose' => 'rocket',
            ],
        ];
        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
