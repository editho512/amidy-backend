<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('name');
            $table->decimal('stock_alert',  5, 2 )->nullable();
            $table->text('description')->nullable();
            $table->text('attributs')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('tva', 5, 2)->nullable();
            $table->decimal('stock', 30, 2)->nullable();
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
        Schema::dropIfExists('products');
    }
}
