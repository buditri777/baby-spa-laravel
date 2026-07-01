<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('booking_id')->unique();
            $table->string('child_id');
            $table->string('therapist_id');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->string('status')->default('ONGOING'); // ONGOING|COMPLETED
            $table->text('notes')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('height_cm')->nullable();
            $table->float('head_circ_cm')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->foreign('child_id')->references('id')->on('children');
            $table->foreign('therapist_id')->references('id')->on('users');
        });
        Schema::create('session_media', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('session_id');
            $table->string('url');
            $table->string('type')->default('IMAGE'); // IMAGE|VIDEO
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('session_id')->references('id')->on('sessions')->cascadeOnDelete();
        });
    }
    public function down(): void {
        Schema::dropIfExists('session_media');
        Schema::dropIfExists('sessions');
    }
};
