<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('cart_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cart_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('product_id')
              ->constrained()
              ->onDelete('cascade');

        $table->integer('qty');
        $table->decimal('price', 10, 2);

        $table->timestamps();

        // same product ek cart me ek hi baar
        $table->unique(['cart_id', 'product_id']);
    });
}

public function down()
{
    Schema::dropIfExists('cart_items');
}

   
};