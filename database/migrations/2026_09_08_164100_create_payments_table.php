<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();
            $table->string('kind', 20)->default('rental'); // rental|late_fee
            $table->string('status', 20)->default('pending'); // pending|settlement|expire|cancel|deny|refund
            $table->string('payment_type')->nullable();
            $table->string('fraud_status')->nullable();
            $table->decimal('gross_amount', 12, 2);
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
