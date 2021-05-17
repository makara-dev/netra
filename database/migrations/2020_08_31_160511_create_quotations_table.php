<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('datetime');
            $table->string('reference_num')->unique();
            $table->string('status');
            $table->decimal('total', 8, 2)->default(0.00);
            $table->string('quotation_note');
            $table->string('staff_note');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')
            ->references('customer_id')
            ->on('customers')
            ->onDelete('set null');
            $table->unsignedBigInteger('exchange_rate_id')->nullable();
            $table->foreign('exchange_rate_id')
            ->references('id')
            ->on('exchange_rates')
            ->onDelete('set null');
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
        Schema::dropIfExists('quotations');
    }
}
