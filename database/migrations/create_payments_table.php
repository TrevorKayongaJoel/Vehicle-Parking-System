<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->enum('method', ['cash', 'mpesa', 'card'])->default('cash');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
{
    Schema::dropIfExists('payments');
}
};