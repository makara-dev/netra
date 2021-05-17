<?php

use App\Staff;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //make the left over user as staff
        $halfUsers = (int) (User::count() / 2) + 1; //included seeded admin
        
        $leftOverUsers = $halfUsers - 1;
        
        $users = User::skip($halfUsers)
            ->take($leftOverUsers)
            ->get();

        //create customers
        foreach($users as $user){
            $user->customer()->save(new Staff());
        }
    }
}
