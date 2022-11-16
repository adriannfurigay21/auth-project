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
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('wallet_id')->nullable(false);
            $table->enum('status', ['paid', 'unpaid', 'pending', 'cancelled'])->default('unpaid');
            $table->decimal('amount', 10, 2)->nullable(false);
            $table->string('note')->nullable();
            $table->enum('type', ['debit', 'credit card', 'cash'])->default('cash');
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

/* note, status, amount, user_id, wallet_id, type*/