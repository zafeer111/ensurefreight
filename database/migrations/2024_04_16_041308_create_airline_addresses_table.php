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
        Schema::create('airline_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrier_id');
            $table->string('address');
            $table->string('sub_address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('port');
            $table->string('sub_location');
            $table->string('contact')->nullable();
            $table->string('tel')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_addresses');
    }
};
