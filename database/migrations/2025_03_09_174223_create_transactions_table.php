<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->nullable(false);
            $table->bigInteger('item_id')->nullable(true);
            $table->string('jenis')->nullable(false);
            $table->string('nama')->nullable('true');
            $table->bigInteger('transaction_wrapper_id')->nullable(true);
            $table->integer('harga')->nullable(false)->default(0);
            $table->integer('cost')->nullable(false)->default(0);
            $table->integer('jumlah')->nullable(false);
            $table->integer('cost_total')->nullable(false);
            $table->timestamps();
            ///foreign
            $table->foreign('item_id')->on('items')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('transaction_wrapper_id')->on('transaction_wrappers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
