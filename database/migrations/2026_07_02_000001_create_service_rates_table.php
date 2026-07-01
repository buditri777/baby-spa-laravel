<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_rates', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('service_id');
            $table->enum('fee_type', ['FLAT','PERCENT'])->default('PERCENT');
            $table->decimal('fee_value', 12, 2)->default(0);
            $table->decimal('homecare_base_fee', 12, 2)->default(0);
            $table->decimal('homecare_per_km_fee', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
            $table->unique('service_id');
        });
    }
    public function down(): void { Schema::dropIfExists('service_rates'); }
};
