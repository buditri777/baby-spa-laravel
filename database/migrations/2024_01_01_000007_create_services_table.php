<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['SPA','THERAPY','FITNESS','EVALUATION']);
            $table->integer('duration_min');
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();
            $table->string('photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('age_min_months')->nullable();
            $table->integer('age_max_months')->nullable();
            $table->string('branch_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            $table->index(['category','is_active']);
            $table->index('branch_id');
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};
