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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('phone_number');
            $table->string('address');
            $table->string('website')->nullable();
            $table->text('service')->nullable();
            $table->text('description')->nullable();
            $table->string('partnership_status'); // Status Partenariat => [Nouveau, Rejeté, Validé]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
