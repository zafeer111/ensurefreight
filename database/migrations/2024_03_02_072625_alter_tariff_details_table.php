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
        Schema::table('tariff_details', function (Blueprint $table) {
            $table->renameColumn('airline_tariff_id','carrier_tariff_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tariff_details', function (Blueprint $table) {
            $table->renameColumn('carrier_tariff_id', 'airline_tariff_id');
        });
    }
};
