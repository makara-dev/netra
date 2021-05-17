<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = App\Customer::whereHas('user', function($q) {
            $q->where('name', 'customer');
        })->first();

        //seed a customer
        $sangkat = App\Sangkat::where('sangkat_name', 'Phsar Depo I')->first();
        logger($sangkat);
        $this->insertShippingAddress($customer, $sangkat, 'st150z, Kampuchea Krom', 'Near Orient Rite Hotel');
    }

    function insertShippingAddress($customer, $sangkat, $address, $note){
    
        $ShippingAddress = new App\ShippingAddress([
            'address' => $address,
            'note' => $note,
            'sangkat_id' => $sangkat->sangkat_id,
        ]);

        // save into db
        $result  = $customer->shippingAddresses()->save($ShippingAddress);
    }
}
