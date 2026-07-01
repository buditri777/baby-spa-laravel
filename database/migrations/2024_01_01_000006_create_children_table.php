<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('children', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('parent_id');
            $table->string('name');
            $table->enum('gender', ['L','P']);
            $table->date('birth_date');
            $table->integer('birth_weight_g')->nullable();
            $table->float('birth_height_cm')->nullable();
            $table->enum('delivery_type', ['NORMAL','SC','VACUUM','FORCEPS'])->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo_url')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('parent_id');
        });
    }
    public function down(): void { Schema::dropIfExists('children'); }
};
