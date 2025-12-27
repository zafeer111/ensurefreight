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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('customer_user_id');
            $table->unsignedBigInteger('carrier_id');
            $table->string('tariff_rate');
            $table->string('surcharge');
            $table->string('airable_charge');
            $table->string('custom_charge');
            $table->string('rate_per_kg');
            $table->string('total_rate');
            $table->string('status')->comment('1 => Accepted, 2 => Pending, 2 => Discard');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
