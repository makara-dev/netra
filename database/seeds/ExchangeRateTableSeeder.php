<?php

use Illuminate\Database\Seeder;
use App\ExchangeRate;

class ExchangeRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exchangeRates = [
            // Currency 1
            [
                'currency_name'  => 'USD Dolla',
                'currency_code'  => 'USD',
                'exchange_rate'  => 1.00,
                'symbol'         => '$',
            ],

            // Currency 2
            [
                'currency_name'  => 'KH Riels',
                'currency_code'  => 'Riels',
                'exchange_rate'  => 4100.00,
                'symbol'         => 'R',
            ],

        ];

        // save data into db
        foreach($exchangeRates as $exchangeRate){
            $exchangeRate = ExchangeRate::create($exchangeRate);
        }
    }
}
