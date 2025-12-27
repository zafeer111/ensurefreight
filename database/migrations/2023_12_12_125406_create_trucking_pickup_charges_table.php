<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trucking_pickup_charges', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_weight');
            $table->decimal('max_weight');
            $table->decimal('rate');
            $table->string('rate_currency')->comment('CAD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucking_pickup_charges');
    }
};
