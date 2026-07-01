<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('child_id');
            $table->string('therapist_id');
            $table->string('service_id');
            $table->string('branch_id')->nullable();
            $table->dateTime('scheduled_at');
            $table->integer('duration_min');
            $table->enum('status', ['REQUESTED','CONFIRMED','COMPLETED','CANCELLED','NO_SHOW'])->default('CONFIRMED');
            $table->decimal('total_price', 12, 2);
            $table->boolean('is_walk_in')->default(false);
            $table->boolean('is_homecare')->default(false);
            $table->decimal('homecare_distance_km', 8, 2)->default(0);
            $table->decimal('homecare_transport_fee', 12, 2)->default(0);
            $table->decimal('homecare_queue_fee', 12, 2)->default(0);
            $table->dateTime('homecare_arrived_at')->nullable();
            $table->dateTime('homecare_finished_at')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('dp_amount', 12, 2)->default(0);
            $table->boolean('dp_forfeited')->default(false);
            $table->dateTime('dp_forfeited_at')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->boolean('reminded_24h')->default(false);
            $table->boolean('reminded_6h')->default(false);
            $table->boolean('reminded_1h')->default(false);
            $table->timestamps();
            $table->foreign('child_id')->references('id')->on('children');
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            $table->index(['status','scheduled_at']);
            $table->index('branch_id');
        });
    }
    public function down(): void { Schema::dropIfExists('bookings'); }
};
