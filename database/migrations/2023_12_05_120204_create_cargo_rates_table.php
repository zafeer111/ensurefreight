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
        Schema::create('cargo_rates', function (Blueprint $table) {
            $table->id();
            $table->string('origin_code');
            $table->string('destination_code');
            $table->decimal('min_weight');
            $table->decimal('max_weight');
            $table->decimal('rate');
            $table->unsignedBigInteger('airline_id');
            $table->timestamps();


            $table->foreign('airline_id')->references('id')->on('carriers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_rates');
    }
};
