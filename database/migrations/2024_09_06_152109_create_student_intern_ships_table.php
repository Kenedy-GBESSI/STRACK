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
        Schema::create('student_intern_ships', function (Blueprint $table) {
            $table->id();
            $table->integer('company_note')->nullable();
            $table->integer('final_note')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_intern_ship_valid')->nullable();

            $table->foreignId('intern_ship_id')
                ->nullable()
                ->constrained();

            $table->foreignId('student_id')
                ->nullable()
                ->constrained();

            $table->foreignId('company_id')
                ->nullable()
                ->constrained();

            // Rapport de stage

            $table->string('file_associated_name')->nullable()->unique();
            $table->text('file_associated_uuid')->nullable();
            $table->string('file_associated_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_intern_ships');
    }
};
