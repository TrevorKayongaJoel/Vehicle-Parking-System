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
    Schema::create('parkings', function (Blueprint $table) {
        $table->id();
        $table->string('vehicle_number');
        $table->timestamp('check_in_time');
        $table->timestamp('check_out_time')->nullable();
        $table->unsignedBigInteger('attendant_id'); // who checked in the vehicle
        $table->decimal('fee', 8, 2)->nullable();
        $table->timestamps();

        $table->foreign('attendant_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
