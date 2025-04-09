<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Owner
        $table->foreignId('parking_slot_id')->nullable()->constrained()->onDelete('set null');
        $table->string('plate_number')->unique();
        $table->string('vehicle_type'); // e.g., car, bike
        $table->timestamp('entry_time')->nullable();
        $table->timestamp('exit_time')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
{
    Schema::dropIfExists('vehicles');
}
};