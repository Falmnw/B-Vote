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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();

            // Relasi ke organisasi
            $table->foreignId('organization_id')->constrained('organizations')
                ->onDelete('cascade');

            // Judul voting
            $table->string('title');

            // Waktu mulai & berakhir
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            
            $table->boolean('is_announced')->default('0');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
