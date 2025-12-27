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
        // Add pickup_carrier_name column to quotations table
        Schema::table('quotations', function (Blueprint $table) {
            if (!Schema::hasColumn('quotations', 'pickup_carrier_name')) {
                $table->string('pickup_carrier_name')->after('pickup_charge')->comment('Trucking carrier');
            }
            $table->softDeletes();
        });

        // Add soft deletes to multiple tables
        $tables = [
            'airport_cities',
            'airport_countries',
            'broker_details',
            'carrier_charges',
            'carrier_details',
            'carrier_tariffs',
            'carrier_tariff_validations',
            'charge_types',
            'exception_inquiries',
            'flights',
            'flight_schedules',
            'measurements',
            'quotation_line_items',
            'reference_nos',
            'trucking_pickup_charges',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove pickup_carrier_name column from quotations table
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('pickup_carrier_name');
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from multiple tables
        $tables = [
            'airport_cities',
            'airport_countries',
            'broker_details',
            'carrier_charges',
            'carrier_details',
            'carrier_tariffs',
            'carrier_tariff_validations',
            'charge_types',
            'exception_inquiries',
            'flights',
            'flight_schedules',
            'measurements',
            'quotation_line_items',
            'reference_nos',
            'trucking_pickup_charges',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};