<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_id')->unique();

            $table->string('customer_name');

            $table->string('customer_email');

            $table->string('customer_phone');

            $table->integer('quantity');

            $table->decimal('ticket_price', 12, 2);

            $table->decimal('admin_fee', 12, 2)->default(5000);

            $table->decimal('total_price', 12, 2);

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};