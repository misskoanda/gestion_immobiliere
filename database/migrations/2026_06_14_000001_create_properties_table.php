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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->enum('type', ['terrain', 'appartement', 'villa', 'batiment', 'commerce']);
            $table->enum('usage', ['residence', 'bureau', 'commerce', 'agriculture']);
            $table->enum('option', ['location', 'vente']);
            $table->string('location');
            $table->decimal('area', 10, 2)->nullable();
            $table->decimal('price', 15, 2);
            $table->text('description');
            $table->enum('status', ['en_attente', 'publiee', 'refusee', 'retiree'])->default('en_attente');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
