<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->unique();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('status', [1, 2, 3])->default(1)->comment('1 => active, 2 => inactive , 3 => draft');
            $table->decimal('price', unsigned: true);
            $table->decimal('compare_price', unsigned: true)->nullable();
            $table->unsignedMediumInteger('qty')->default(0);
            $table->json('options')->nullable();
            $table->unsignedFloat('rating', 2, 1)->default(0);
            $table->boolean('feature')->default(0);
            $table->unsignedBigInteger('viewed')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
