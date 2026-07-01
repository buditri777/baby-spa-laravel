<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('growth_measurements', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('child_id');
            $table->string('session_id')->nullable();
            $table->date('measured_at');
            $table->float('weight_kg')->nullable();
            $table->float('height_cm')->nullable();
            $table->float('head_circ_cm')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('child_id')->references('id')->on('children')->cascadeOnDelete();
            $table->index(['child_id','measured_at']);
        });
        Schema::create('milestones', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('child_id');
            $table->string('milestone_key');
            $table->boolean('achieved')->default(false);
            $table->date('achieved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('child_id')->references('id')->on('children')->cascadeOnDelete();
            $table->unique(['child_id','milestone_key']);
        });
        Schema::create('home_exercises', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('child_id');
            $table->string('session_id')->nullable();
            $table->string('title');
            $table->text('content')->nullable(); // markdown
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('child_id')->references('id')->on('children')->cascadeOnDelete();
        });
    }
    public function down(): void {
        Schema::dropIfExists('home_exercises');
        Schema::dropIfExists('milestones');
        Schema::dropIfExists('growth_measurements');
    }
};
