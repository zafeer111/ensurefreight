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
        Schema::create('carrier_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id');
            $table->foreignId('currency_id');
            $table->decimal('charges_amt')->default(0.00);
            $table->foreignId('charge_type_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_charges');
    }
};
