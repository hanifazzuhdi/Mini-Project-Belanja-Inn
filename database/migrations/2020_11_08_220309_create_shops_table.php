<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('shop_name')->unique();
            $table->string('avatar')->default('https://iili.io/FqzDMX.md.png');
            $table->string('address');
            $table->text('description');
            $table->timestamps();

<<<<<<< HEAD
            $table->foreign('user_id')->references('id')->on('users');
=======
            $table->foreign('shop_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
>>>>>>> 632dac16d813c568cd950706029262951c6d73c3
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
