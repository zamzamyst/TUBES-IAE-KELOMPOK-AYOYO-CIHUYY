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
        Schema::connection('mysql_tracking')->dropIfExists('trackings');
        Schema::connection('mysql_tracking')->create('trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id')->unique();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->timestamps();

            // Foreign key constraint removed - deliveries table is in a separate database
            // Reference is maintained via delivery_id without DB constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_tracking')->dropIfExists('trackings');
    }
};
