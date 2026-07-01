<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('therapist_fees', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('therapist_id');
            $table->string('branch_id')->nullable();
            $table->decimal('honor_per_session', 12, 2)->nullable();
            $table->decimal('fee_percent', 5, 2)->nullable();
            $table->decimal('base_salary', 12, 2)->nullable();
            $table->timestamps();
            $table->foreign('therapist_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('branch_id')->nullable();
            $table->string('created_by_id')->nullable();
            $table->integer('year');
            $table->integer('month'); // 1-12
            $table->string('status')->default('DRAFT'); // DRAFT|FINALIZED|REOPENED
            $table->dateTime('finalized_at')->nullable();
            $table->timestamps();
            $table->unique(['year','month','branch_id']);
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
        });
        Schema::create('payslips', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('payroll_period_id');
            $table->string('therapist_id');
            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('session_fee', 12, 2)->default(0);
            $table->integer('total_sessions')->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->cascadeOnDelete();
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->unique(['payroll_period_id','therapist_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('payslips');
        Schema::dropIfExists('payroll_periods');
        Schema::dropIfExists('therapist_fees');
    }
};
