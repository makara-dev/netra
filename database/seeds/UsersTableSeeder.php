<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 10; $i++){
            App\User::create([
                'name' => $faker->unique()->name,
                'email' => $faker->unique()->email,
                'email_verified_at' => $faker->dateTimeThisMonth,
                'password' => $faker->password(6,10)
            ]);
       }
    }
}
