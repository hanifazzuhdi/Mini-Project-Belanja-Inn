<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');
            $table->integer('status')->default(0);
            $table->integer('quantity');
            $table->integer('total_price')->nullable();
            $table->timestamps();

            // $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
