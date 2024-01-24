<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role_translations', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');

            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();

            $table->unique(['locale', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_translations');
    }
};
