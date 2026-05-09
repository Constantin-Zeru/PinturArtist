<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name'); // preparación, lijado, imprimación, primera mano...
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->string('status', 20)->default('pendiente'); // pendiente, en_proceso, completada
            $table->date('phase_date')->nullable();
            $table->decimal('hours_spent', 8, 2)->nullable();

            $table->text('observations')->nullable();

            $table->boolean('requires_photo')->default(true);
            $table->boolean('requires_video')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phases');
    }
};