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
        Schema::create('tariff_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_tariff_id');
            $table->string('origin_code');
            $table->string('destination_code');
            $table->decimal('min_weight')->comment('weight always in kg');
            $table->decimal('max_weight')->comment('weight always in kg');
            $table->decimal('rate');
            $table->timestamps();

            $table->foreign('airline_tariff_id')->references('id')->on('airline_tariffs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_details');
    }
};
