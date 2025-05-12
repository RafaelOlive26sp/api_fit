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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('status',['scheduled','completed','cancelled'])->default('scheduled');
            $table->foreignId('students_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_schedules_id')->constrained('class_schedules')->onDelete('cascade');
            $table->foreignId('payments_id')->constrained('payments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
