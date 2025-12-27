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
        Schema::create('carrier_tariff_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_tariff_id');
            $table->date('valid_at')->nullable();
            $table->date('expire_at')->nullable();
            $table->double('max_height')->default(0.00);
            $table->double('max_width')->default(0.00);
            $table->double('max_length')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_validations');
    }
};
