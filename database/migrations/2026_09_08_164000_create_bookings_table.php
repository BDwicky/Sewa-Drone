<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 12)->unique();
            $table->foreignId('drone_id')->constrained()->cascadeOnDelete();
            $table->string('renter_name');
            $table->string('phone', 25);
            $table->string('email')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('days');
            $table->decimal('total_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->boolean('with_pilot')->default(false);
            $table->boolean('delivery')->default(false);
            $table->string('status', 20)->default('pending'); // pending|confirmed|active|completed|cancelled
            $table->text('notes')->nullable();
            $table->string('payment_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
