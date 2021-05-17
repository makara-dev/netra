<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\District::insert([
            ['district_name' => 'Khan Russei Keo'],
            ['district_name' => 'Khan Toulkok'],
            ['district_name' => 'Khan Daun Penh'],
            ['district_name' => 'Khan 7 Makara'],
            ['district_name' => 'Khan Por Senchey'],
            ['district_name' => 'Khan Sen Sok'],
            ['district_name' => 'Khan Boeng Keng Kang'],
            ['district_name' => 'Khan Chamkarmorn'],
            ['district_name' => 'Khan Meanchey'],
            ['district_name' => 'Khan Dang Kor'],
            ['district_name' => 'Khan Chba Ampoeu'],
            ['district_name' => 'Khan Chroy Chang Va'],
            ['district_name' => 'Khan Prek Phnov'],
        ]);
    }
}
