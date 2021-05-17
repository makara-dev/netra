<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('adjustment_id');
            $table->foreign('adjustment_id')->references('id')->on('adjustments')->onDelete('cascade');

            $table->unsignedBigInteger('product_variant_id');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('product_variants')->onDelete('cascade');

            $table->integer ('quantity')->default(0);
            $table->string('type');
            
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
        Schema::dropIfExists('product_variant_adjustments');
    }
}
