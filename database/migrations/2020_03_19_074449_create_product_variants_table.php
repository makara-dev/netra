<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('product_variant_id');
            $table->string('product_variant_sku');
            // $table->string('product_variant_name');
            $table->unsignedDecimal('cost',8,2);
            $table->unsignedDecimal('price',8,2);
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('created_by')->references('staff_id')->on('staffs')->onDelete('set null');
            $table->foreign('updated_by')->references('staff_id')->on('staffs')->onDelete('set null');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
