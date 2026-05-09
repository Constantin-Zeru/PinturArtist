<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phase_material', function (Blueprint $table) {
            $table->foreignId('phase_id')->constrained('phases')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();

            $table->decimal('quantity_used', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->unique(['phase_id', 'material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phase_material');
    }
};