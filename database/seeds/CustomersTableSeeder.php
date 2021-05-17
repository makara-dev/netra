<?php

use Illuminate\Support\Facades\Log;
use App\Customer;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Faker\Factory::create();

        $halfUserCount = (int) (User::count() / 2);
        
        $users =
            User::skip(1)           //skip seeded admin
            ->take($halfUserCount)
            ->get();

        //create customers
        foreach($users as $user){
            $customer = new Customer([
                'point' => $faker->numberBetween(0,100),
                'customer_group_id' => $faker->numberBetween(1,4),
            ]);
            $user->customer()->save($customer);
        }

        //authenticatable customer
        $user = User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer123'),
            'email_verified_at' => Carbon::now(),
        ])->customer()->save(new Customer([]));
    }
}
