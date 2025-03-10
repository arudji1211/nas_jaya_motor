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
            $table->id();
            $table->integer('user_id')->on('users')->references('id')->nullable(false);
            $table->foreign('item_id')->on('items')->references('id')->nullable(true);
            $table->string('jenis')->nullable(false);
            $table->string('nama')->nullable('false');
            $table->foreign('transaction_wrapper_id')->on('transaction_wrappers')->references('id')->nullable(true);
            $table->integer('cost')->nullable(true);
            $table->integer('jumlah')->nullable(false);
            $table->integer('cost_total')->nullable(false);
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
        Schema::dropIfExists('transactions');
    }
};
