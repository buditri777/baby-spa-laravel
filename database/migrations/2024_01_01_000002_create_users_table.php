<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('phone')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('name');
            $table->enum('role', ['PARENT','THERAPIST','OWNER','ADMIN','RECEPTIONIST','DIREKTUR','SUPER_ADMIN'])->default('PARENT');
            $table->string('photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('address_line')->nullable();
            $table->decimal('homecare_latitude', 10, 7)->nullable();
            $table->decimal('homecare_longitude', 10, 7)->nullable();
            $table->string('referral_source')->nullable();
            $table->string('ig_username')->nullable()->unique();
            $table->string('fcm_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            $table->index('branch_id');
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
