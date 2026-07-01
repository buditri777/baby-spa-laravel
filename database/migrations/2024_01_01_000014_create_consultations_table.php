<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('consultations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('parent_id');
            $table->string('child_id')->nullable();
            $table->string('therapist_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('status')->default('OPEN'); // OPEN|CLAIMED|CLOSED|EXPIRED
            $table->string('topic')->nullable();
            $table->dateTime('claimed_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('last_activity_at')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('users');
            $table->foreign('therapist_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['status','branch_id']);
        });
        Schema::create('consultation_messages', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('consultation_id');
            $table->string('sender_id');
            $table->text('body');
            $table->string('type')->default('TEXT'); // TEXT|IMAGE|FILE
            $table->string('file_url')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('consultation_id')->references('id')->on('consultations')->cascadeOnDelete();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->index('consultation_id');
        });
    }
    public function down(): void {
        Schema::dropIfExists('consultation_messages');
        Schema::dropIfExists('consultations');
    }
};
