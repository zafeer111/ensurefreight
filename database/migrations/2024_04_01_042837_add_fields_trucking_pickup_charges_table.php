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
        Schema::table('trucking_pickup_charges', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->decimal('min_rate')->after('max_weight');
            $table->decimal('max_rate')->after('min_rate');
            $table->boolean('is_fixed')->default(false)->after('max_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trucking_pickup_charges', function (Blueprint $table) {
            $table->decimal('rate');
            $table->dropColumn('min_rate');
            $table->dropColumn('max_rate');
            $table->dropColumn('is_fixed');
        });
    }
};
