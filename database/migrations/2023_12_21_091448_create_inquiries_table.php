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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('mode')->default(1)->comment('1 = air, 2 = road');
            $table->unsignedTinyInteger('priority')->default(1)->comment('1 = standard time, 2 = critical time');
            $table->unsignedTinyInteger('cargo_type');
            $table->unsignedTinyInteger('status')->default(1)->comment('1 => initiate, 2 => viewed, 3 => answered, 4 => rejected');
            $table->string('commodity');
            $table->unsignedBigInteger('supplier_address_id');
            $table->unsignedBigInteger('delivery_address_id');
            $table->unsignedBigInteger('broker_detail_id')->nullable();
            $table->string('pickup_reference');
            $table->string('incoterms');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('customer_user_id');
            $table->text('user_agent')->nullable()->comment('User agent information');
            $table->string('ip')->nullable()->comment('IP address');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_address_id')->references('id')->on('addresses');
            $table->foreign('delivery_address_id')->references('id')->on('addresses');
            $table->foreign('customer_user_id')->references('id')->on('customer_users');
            $table->foreign('broker_detail_id')->references('id')->on('broker_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
