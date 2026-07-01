<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ig_reservations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('ig_username');
            $table->string('user_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('handler_id')->nullable();
            $table->string('status')->default('PENDING'); // PENDING|CONFIRMED|CANCELLED
            $table->text('message')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
            $table->foreign('handler_id')->references('id')->on('users')->nullOnDelete();
        });
        Schema::create('settings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id')->nullable();
            $table->string('action');
            $table->string('target_type')->nullable();
            $table->string('target_id')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id','created_at']);
            $table->index(['target_type','target_id']);
        });
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id')->nullable();
            $table->string('phone');
            $table->string('type'); // REMINDER|BIRTHDAY|FOLLOW_UP
            $table->text('message')->nullable();
            $table->string('status')->default('SENT');
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('whatsapp_logs');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('ig_reservations');
    }
};
