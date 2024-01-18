<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->unsignedFloat('amount');
            $table->unsignedFloat('amount_received');
            $table->char('currency', 3)->default('USD');
            $table->string('service_used');
            $table->string('method_type')->nullable();
            $table->enum('status', [1, 2, 3, 4])->default(1)->comment('1 => Pending, 2 => Complete, 3 => Failed, 4 => Cancelled');
            $table->string('transaction_id')->nullable()->index();
            $table->json('transaction_data')->nullable();
            $table->timestamps();

            $table->unique(['transaction_id', 'order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
