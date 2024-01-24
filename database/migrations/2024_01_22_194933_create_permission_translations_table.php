<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permission_translations', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');

            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();

            $table->unique(['locale', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_translations');
    }
};
