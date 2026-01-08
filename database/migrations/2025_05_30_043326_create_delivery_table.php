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
        Schema::connection('mysql_delivery')->dropIfExists('deliveries');
        Schema::connection('mysql_delivery')->create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique();
            $table->text('delivery_address');
            $table->enum('delivery_status', ['pending', 'in_transit', 'delivered', 'cancelled'])->default('pending');
            $table->timestamps();

            // Foreign key constraint removed - orders table is in a separate database
            // Reference is maintained via order_id without DB constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_delivery')->dropIfExists('deliveries');
    }
};
