<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductvarGiftsetBridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productvar_giftset_bridges', function (Blueprint $table) {
            $table->unsignedBigInteger('giftset_id');
            $table->unsignedBigInteger('product_variant_id');

            $table->foreign('giftset_id')->references('giftset_id')->on('giftsets')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productvar_giftset_bridges');
    }
}
