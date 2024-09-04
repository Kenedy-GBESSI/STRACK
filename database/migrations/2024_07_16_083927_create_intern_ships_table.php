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
        Schema::create('intern_ships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('academic_year');

            // File associated
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
        Schema::dropIfExists('intern_ships');
    }
};
