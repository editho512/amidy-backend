<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer("payment_method")->comment("linked to the constant within the Payment Model");
            $table->unsignedBigInteger('order_id')->unsigned()->comment('that user id is the one of the customer who the payment belongs to');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->decimal('amount', 30, 2);
            $table->text('attributes')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
