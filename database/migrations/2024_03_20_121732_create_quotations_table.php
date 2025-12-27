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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->string('from')->comment('origin');
            $table->string('to')->comment('dest');
            $table->string('weight')->comment('kg');
            $table->string('profit');
            $table->string('pickup_charge')->comment('charges');
            $table->string('bonded_charge')->comment('charges');
            $table->string('cargo_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
