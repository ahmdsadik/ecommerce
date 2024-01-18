<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cookie_id')->index();

            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

//            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
//
//            $table->unsignedMediumInteger('qty')->default(0);
//
//            $table->json('options')->nullable();

            $table->timestamps();

//            $table->unique(['product_id', 'cookie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
