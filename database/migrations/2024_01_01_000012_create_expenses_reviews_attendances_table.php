<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('expenses', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('branch_id')->nullable();
            $table->string('recorded_by_id')->nullable();
            $table->string('category');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('receipt_url')->nullable();
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            $table->index(['branch_id','expense_date']);
        });
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('booking_id')->unique();
            $table->string('therapist_id');
            $table->string('parent_id');
            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('users');
        });
        Schema::create('attendances', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('therapist_id');
            $table->string('branch_id')->nullable();
            $table->date('date');
            $table->dateTime('clock_in')->nullable();
            $table->dateTime('clock_out')->nullable();
            $table->dateTime('homecare_start_at')->nullable();
            $table->dateTime('homecare_end_at')->nullable();
            $table->string('status')->default('PRESENT');
            $table->timestamps();
            $table->foreign('therapist_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['therapist_id','date']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('expenses');
    }
};
