<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_details', function (Blueprint $table) {
            $table->bigIncrements('shipping_detail_id');
            
            $table->string('name');
            $table->string('contact', 20);
            $table->string('email')->nullable();

            $table->string('address')->nullable();
            $table->string('apartment_unit')->nullable();
            $table->string('sangkat_name')->nullable();
            $table->string('district_name')->nullable();
            
            $table->text('note')->nullable();
            $table->string('receiver_numbers')->nullable();

            $table->unsignedBigInteger('order_id');           
            $table->timestamps();
            
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
        Schema::dropIfExists('shipping_details');
    }
}
