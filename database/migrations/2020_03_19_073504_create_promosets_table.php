<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promosets', function (Blueprint $table) {
            $table->bigIncrements('promoset_id');
            $table->string('promoset_name', '100')->unique();
            $table->integer('promoset_condition');
            $table->integer('provider_condition');
            $table->unsignedDecimal('discount_price_offer',8,2)->nullable();
            $table->string('promoset_thumbnail')->nullable();
            $table->string('promoset_description', '500')->nullable();

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
        Schema::dropIfExists('promosets');
    }
}
