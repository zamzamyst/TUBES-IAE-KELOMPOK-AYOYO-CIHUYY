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
        Schema::connection('mysql_order')->dropIfExists('orders');
        Schema::connection('mysql_order')->create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('menu_code');
            $table->string('name');
            $table->string('price');
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_order')->dropIfExists('orders');
    }
};
