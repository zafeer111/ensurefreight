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
        Schema::table('quotation_line_items', function (Blueprint $table) {
            $table->string('surcharge')->nullable()->change();
            $table->string('airable_charge')->nullable()->change();
            $table->string('custom_charge')->nullable()->change();
            $table->string('zero_profit_rate')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_line_items', function (Blueprint $table) {
            $table->string('surcharge')->change();
            $table->string('airable_charge')->change();
            $table->string('custom_charge')->change();
            $table->string('zero_profit_rate')->change();
        });
    }
};
