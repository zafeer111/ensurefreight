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
        Schema::create('quotation_line_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrier_id');
            $table->string('tariff_rate');
            $table->string('surcharge')->comment('charges');
            $table->string('airable_charge')->comment('charges');
            $table->string('custom_charge')->comment('charges');
            $table->string('rate_per_kg');
            $table->string('zero_profit_rate');
            $table->string('total_rate');
            $table->string('status')->default(0)->comment('0 => Initiate, 1 => Accepted, 2 => Rejected, 3 => Negotiate');
            $table->unsignedBigInteger('quotable_id');
            $table->string('quotable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_line_items');
    }
};
