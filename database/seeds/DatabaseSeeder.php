<?php

use App\ProductVariant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UsersTableSeeder::class,
            StaffsTableSeeder::class,
            CustomerGroupTableSeeder::class,
            CustomersTableSeeder::class,
            AttributesTableSeeder::class,
            AttributeValuesTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            ProductVariantsTableSeeder::class,
            ProductVariantAttributeValueBridgesTableSeeder::class,
            DistrictsTableSeeder::class,
            SangkatsTableSeeder::class,
            ShippingAddressesTableSeeder::class,
            GiftsetTableSeeder::class,
            ProductVariantGiftsetTableSeeder::class,
            PromosetTableSeeder::class,
            PvFreePromosetSeeder::class,
            PvPurchasePromosetSeeder::class,
            ExchangeRateTableSeeder::class,
            QuotationSeeder::class,
            SaleTableSeeder::class,
            OrderTableSeeder::class,
            // GiftsetAttributeValueBridgesSeeder::class,
        ]);
    }
}
