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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('user_reference_number')->nullable()->unique();
            $table->string('system_reference_number')->unique();
            $table->renameColumn('supplier_address_id','pickup_address_id');
            $table->dropForeign(['delivery_address_id']);
            $table->dropColumn('delivery_address_id');
            $table->string('dest_iata')->nullable()->after('shipment_address_id');
            $table->string('destination_postal_code')->nullable()->after('dest_iata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('user_reference_number');
            $table->dropColumn('system_reference_number');
            $table->renameColumn('supplier_address_id','pickup_address_id');
            $table->unsignedBigInteger('delivery_address_id');
            $table->dropColumn('dest_iata');
            $table->dropColumn('destination_postal_code');
        });
    }
};
