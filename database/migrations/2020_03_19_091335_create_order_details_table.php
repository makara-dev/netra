<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('order_detail_id');
            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->string('attributes_name')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('cost', 8, 2);
            $table->unsignedDecimal('price', 8, 2);
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->timestamps();

            $table->foreign('product_variant_id')->references('product_variant_id')->on('product_variants')->onDelete('set null');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
