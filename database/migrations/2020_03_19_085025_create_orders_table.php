<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->string('order_number')->unique();
            $table->string('payment_method')->default('cash on delivery');
            $table->unsignedDecimal('total_cost');
            $table->unsignedDecimal('total_price');
            $table->unsignedDecimal('delivery_fee', 8, 2);
            $table->unsignedDecimal('grand_total');
            $table->unsignedDecimal('sale_tax', 3, 2)->default(0.00);
            $table->string('sale_type')->default("Online");

            $table->enum('order_status',    ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status',  ['pending', 'partial', 'paid', 'cancel'])->default('pending');
            $table->enum('delivery_status', ['pending', 'delivering', 'delivered', 'cancel'])->default('pending');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->timestamps();

            $table->foreign('promotion_id')->references('promotion_id')->on('promotions')->onDelete('cascade');
            $table->unsignedBigInteger('exchange_rate_id')->nullable();
            $table->foreign('exchange_rate_id')
                ->references('id')
                ->on('exchange_rates')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
