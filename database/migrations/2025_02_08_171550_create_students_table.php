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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->enum('gender',['male','female']);
            $table->boolean('smoker');
            $table->text('medical_condition')->nullable();
            $table->boolean('previous_experience');
            $table->boolean('currently_praticing');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
