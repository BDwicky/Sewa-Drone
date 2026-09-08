<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('camera')->nullable();
            $table->unsignedSmallInteger('flight_time_min')->nullable();
            $table->unsignedSmallInteger('range_km')->nullable();
            $table->unsignedInteger('weight_g')->nullable();
            $table->decimal('daily_rate', 12, 2);
            $table->decimal('weekly_rate', 12, 2)->nullable();
            $table->decimal('pilot_daily_rate', 12, 2)->nullable();
            $table->decimal('delivery_fee', 12, 2)->nullable();
            $table->decimal('replacement_value', 12, 2)->nullable();
            $table->unsignedTinyInteger('stock')->default(1);
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drones');
    }
};
