<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InsertAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin@123'), 'phone_number' => 9876543210, 'type' => 1],
            ['name' => 'Super Admin', 'email' => 'super.admin@gmail.com', 'password' => Hash::make('super@123'), 'phone_number' => 9876543211, 'type' => 2]
        ];

        try {
            foreach ($users as $user) {
                User::create($user);
            }
        } catch (\Exception $exception) {
            error_log('InsertAdminUserSeeder', ['message' => $exception->getMessage()]);
        }
    }
}
