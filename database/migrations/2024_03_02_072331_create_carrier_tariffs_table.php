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
        Schema::create('carrier_tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id');
            $table->tinyInteger('cargo_type')->default(1)->comment('1: GCR, 2: DGR PAX,');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_tariffs');
    }
};
