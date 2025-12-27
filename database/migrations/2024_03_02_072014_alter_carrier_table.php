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
        Schema::table('carriers', function (Blueprint $table) {
            $table->tinyInteger('type')->after('logo')->default(1)->comment("1 =>airline , 2 => truck ,3 => ship, 4 => train");
            $table->tinyInteger('status')->after('type')->default(1)->comment("0 => in-active , 1 => active");
            $table->string('carrier_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->string('carrier_code')->nullable(false)->change();
        });
    }
};
