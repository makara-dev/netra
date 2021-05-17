<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsetAttrvalBridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftset_attrval_bridges', function (Blueprint $table) {
            $table->bigIncrements('giftset_attrvals_id');
            $table->unsignedBigInteger('attribute_value_id');
            $table->unsignedBigInteger('giftset_id');
            $table->timestamps();

            $table->foreign('giftset_id')->references('giftset_id')->on('giftsets')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('attribute_value_id')->on('attribute_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftset_attrval_bridges');
    }
}
