<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommend_products', function (Blueprint $table) {
            $table->bigIncrements('recommend_product_id');
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->string('thumbnail')->nullable()->nullable();

            $table->foreign('product_variant_id')->references('product_variant_id')->on('product_variants')->onDelete('cascade');
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
        Schema::dropIfExists('recommend_products');
    }
}
