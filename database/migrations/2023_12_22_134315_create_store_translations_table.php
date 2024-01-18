<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_translations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('short_description')->nullable();

            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();

            $table->unique(['store_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_translations');
    }
};
