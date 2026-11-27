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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('device_code', 30)->unique();
            $table->string('name', 20);
            $table->string('location', 60)->nullable();
            $table->string('wifi_ssid', 64)->nullable();
            $table->char('token_hash', 64)->unique();
            $table->unsignedSmallInteger('warning_ppm')->default(18);
            $table->unsignedSmallInteger('danger_ppm')->default(35);
            $table->unsignedSmallInteger('send_interval_seconds')->default(5);
            $table->unsignedSmallInteger('buzzer_max_seconds')->default(60);
            $table->string('telegram_chat_id', 32)->nullable();
            $table->boolean('notify_on_warning')->default(true);
            $table->boolean('notify_on_danger')->default(true);
            $table->unsignedInteger('config_version')->default(1);
            $table->string('sensor_status', 12)->nullable();
            $table->string('firmware_version', 20)->nullable();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
