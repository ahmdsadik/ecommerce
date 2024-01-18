<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->unsignedMediumInteger('qty')->default(0);

            $table->json('options')->nullable();

            $table->unique(['product_id', 'cart_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};
