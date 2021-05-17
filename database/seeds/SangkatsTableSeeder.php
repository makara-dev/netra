<?php

use App\District;
use Illuminate\Database\Seeder;

class SangkatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Toul Kork
        $toulKork = App\District::where('district_name', 'Khan Toulkok')->first();

        $this->insertSangkat($toulKork, "Boeung Kak II", 3);
        $this->insertSangkat($toulKork, "Phsar Depo I", 5);
        $this->insertSangkat($toulKork, "Phsar Depo II", 3.5);
        $this->insertSangkat($toulKork, "Phsar Depo III", 6);
        $this->insertSangkat($toulKork, "Teuk L'ak I", 3);
        $this->insertSangkat($toulKork, "Teuk L'ak II", 4);
        $this->insertSangkat($toulKork, "Teuk L'ak III", 2);
        $this->insertSangkat($toulKork, "Phsar Daeum Kor", 3);
        $this->insertSangkat($toulKork, "Boeung Salang", 5);

        //Sen sok
        $sensok = App\District::where('district_name', 'Khan Sen Sok')->first(); 

        $this->insertSangkat($sensok, "Phnom Penh Thmei", 2);
        $this->insertSangkat($sensok, "Tuek Thla", 4);
        $this->insertSangkat($sensok, "Khmuonh", 5);
        $this->insertSangkat($sensok, "Krang Thnong", 3);
        $this->insertSangkat($sensok, "Ou Baek K'am", 4);
        $this->insertSangkat($sensok, "Kouk Khleang", 3);

    }

    function insertSangkat(District $district,string $sangkatName, $deliveryFee){
 
        $Sangkat = new App\Sangkat([
            'sangkat_name' => $sangkatName,
            'delivery_fee' => $deliveryFee,
        ]);

        // save to db
        $district->sangkats()->save($Sangkat);
    }
}
