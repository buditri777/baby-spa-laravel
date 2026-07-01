<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('therapists', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->text('bio')->nullable();
            $table->text('certifications')->nullable();
            $table->string('specializations'); // JSON array
            $table->integer('years_experience')->nullable();
            $table->float('rating')->default(5.0);
            $table->integer('total_sessions')->default(0);
            $table->boolean('is_available')->default(true);
            $table->decimal('honor_per_session', 12, 2)->nullable();
            $table->decimal('fee_percent', 5, 2)->nullable();
            $table->decimal('base_salary', 12, 2)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::create('schedules', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('therapist_id');
            $table->tinyInteger('day_of_week'); // 0=Sun,6=Sat
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('is_active')->default(true);
            $table->unique(['therapist_id','day_of_week']);
            $table->foreign('therapist_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::create('schedule_exceptions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('therapist_id');
            $table->date('date');
            $table->string('type'); // OFF|EXTRA
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('reason')->nullable();
            $table->index(['therapist_id','date']);
            $table->foreign('therapist_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(): void {
        Schema::dropIfExists('schedule_exceptions');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('therapists');
    }
};
