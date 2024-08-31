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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities')->nullable();

            $table->foreignId('intern_ship_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // Fichier de detail
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
        Schema::dropIfExists('offers');
    }
};
