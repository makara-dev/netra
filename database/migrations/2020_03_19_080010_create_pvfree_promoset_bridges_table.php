<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvfreePromosetBridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvfree_promoset_bridges', function (Blueprint $table) {
            $table->unsignedBigInteger('promoset_id');
            $table->unsignedBigInteger('product_variant_id');

            $table->foreign('promoset_id')->references('promoset_id')->on('promosets')->onDelete('cascade');
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
        Schema::dropIfExists('pvfree_promoset_bridges');
    }
}
