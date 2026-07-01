<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('therapist_day_actives', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('therapist_id');
            $table->date('date');
            $table->string('branch_id')->nullable();
            $table->string('created_by_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['therapist_id','date']);
            $table->index('date');
            $table->index(['branch_id','date']);
        });
    }
    public function down(): void { Schema::dropIfExists('therapist_day_actives'); }
};
