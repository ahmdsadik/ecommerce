<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('short_description')->nullable();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();

            $table->unique(['locale', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
