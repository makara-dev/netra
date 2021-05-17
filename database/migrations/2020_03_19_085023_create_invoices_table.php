<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('invoice_id');
            $table->unsignedDecimal('total_cost', 8, 2);
            $table->unsignedDecimal('total_price', 8, 2);
            $table->unsignedDecimal('delivery_fee', 8, 2);
            $table->unsignedDecimal('sale_tax', 3, 2)->default(0.00);
            $table->unsignedDecimal('grand_total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
