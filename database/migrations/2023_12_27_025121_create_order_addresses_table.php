<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [1, 2]);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->string('street_address');
            $table->string('postal_code')->nullable();
            $table->string('city');
            $table->string('state')->nullable();

            // TODO:: Use the Countries Package and make this char 2
            $table->string('country');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
