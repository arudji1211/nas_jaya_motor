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
            $table->integer('item_id')->nullable(true);
            $table->string('jenis')->nullable(false);
            $table->string('nama')->nullable('false');
            $table->integer('transaction_wrapper_id')->nullable(true);
            $table->integer('harga')->nullable(false)->default(0);
            $table->integer('cost')->nullable(false)->default(0);
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
