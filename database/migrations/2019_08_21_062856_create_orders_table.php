<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->id('id');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('total_amount');
            $table->string('discount');
            $table->enum('payment_method',['cash','card','transfer','cheque']);
            $table->enum('order_status',['successful','pending','failed']);
            $table->string('cashier_name');
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
        Schema::dropIfExists('orders');
    }
}
