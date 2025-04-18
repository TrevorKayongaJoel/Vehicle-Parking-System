<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('parking_records', function (Blueprint $table) {
        $table->id();
        $table->string('vehicle_number');
        $table->foreignId('parking_slot_id')->constrained()->onDelete('cascade');
        $table->timestamp('check_in_time')->nullable();
        $table->timestamp('check_out_time')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkin_recods');
    }
};
