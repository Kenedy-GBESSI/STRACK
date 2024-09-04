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
            $table->string('matriculation_number')->unique();
            $table->string('study_field'); // Filière;
            $table->string('internship_status'); // Status Stage => [En stage, Pas de stage, Fin de stage]
            $table->string('academic_year');

            // Information's stage
            $table->integer('company_note')->nullable();
            $table->integer('final_note')->nullable();
            $table->foreignId('intern_ship_id')
                ->nullable()
                ->constrained();

            // Fichier de rapport
            $table->string('file_associated_name')->nullable()->unique();
            $table->text('file_associated_uuid')->nullable();
            $table->string('file_associated_path')->nullable();

            $table->boolean('is_intern_ship_valid')->default(false);

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
