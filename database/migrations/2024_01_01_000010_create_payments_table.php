<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('booking_id');
            $table->decimal('amount', 12, 2);
            $table->string('method')->nullable(); // CASH|TRANSFER|QRIS
            $table->string('status')->default('PENDING'); // PENDING|PAID|FAILED|REFUNDED
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('midtrans_transaction_id')->nullable();
            $table->text('midtrans_payload')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->index(['status','paid_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
