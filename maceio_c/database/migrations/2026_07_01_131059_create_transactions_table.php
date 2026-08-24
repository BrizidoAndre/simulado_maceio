<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id');
            $table->integer('amount');
            $table->dateTime('transaction_date');
            $table->enum('status', ['Paid', 'Pending', 'Not apply', 'Suspended', 'Cancelled']);
            $table->integer('usage_count');
            $table->foreignId('worker_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
