<?php

use App\ProductVariant;
use Illuminate\Database\Seeder;
use App\Quotation;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // quotation 1
        $quotations = [
            [
                'datetime' => '12-03-2021',
                'reference_num' => '01',
                'status' => '0',
                'total' => 1,
                'quotation_note' => 'fanta',
                'staff_note' => 'fanta',
                'staff_note' => 'fanta',
                'customer_id' => 1,
                'exchange_rate_id' => 1,
            ],
            [
                'datetime' => '25-03-2021',
                'reference_num' => '03',
                'status' => '0',
                'total' => 4,
                'quotation_note' => 'Coca',
                'staff_note' => 'Coca',
                'customer_id' => 2,
                'exchange_rate_id' => 2,
            ],
            [
                'datetime' => '21-03-2021',
                'reference_num' => '05',
                'status' => '1',
                'total' => 1,
                'quotation_note' => 'Coffee',
                'staff_note' => 'Coffee',
                'customer_id' => 3,
                'exchange_rate_id' => 2,
            ],
        ];

        // save data into db
        foreach ($quotations as $quotation) {
            $quotation = Quotation::create($quotation);
            for ($i = 0; $i <= 2; $i++) {
                $productvar = ProductVariant::find(rand(0, 4));
                $quotation->productvars()->attach($productvar);
            }
        }
    }
}