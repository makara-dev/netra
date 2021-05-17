<?php

use App\User;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        //create a super user
        $adminId = App\User::insertGetId([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_NAME'). '@gmail.com',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'email_verified_at' => $now,
            'created_at' => $now
        ]);

        //set as admin
        App\Staff::create([
            'is_admin' => true,
            'user_id' => $adminId,
        ]);
    }
}
