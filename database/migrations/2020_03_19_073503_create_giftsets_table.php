<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftsets', function (Blueprint $table) {
            $table->bigIncrements('giftset_id');
            $table->string('giftset_name','100')->unique();
            $table->unsignedDecimal('giftset_cost',8,2)->nullable(); // original cost
            $table->unsignedDecimal('giftset_price',8,2);           // new giftset price
            $table->string('thumbnail')->nullable();
            $table->string('giftset_description', '500')->nullable();
            $table->date('expires_at')->nullable();
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
        Schema::dropIfExists('giftsets');
    }
}
