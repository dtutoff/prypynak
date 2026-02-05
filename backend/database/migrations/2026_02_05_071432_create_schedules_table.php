<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transport_id')->constrained()->cascadeOnDelete();

            $table->string('arrival_time');
            $table->enum('day_type', ['workday', 'weekend'])->default('workday');

            $table->boolean('is_backward')->default(false);
            $table->index(['transport_id', 'stop_id', 'day_type', 'is_backward'], 'schedule_search_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
