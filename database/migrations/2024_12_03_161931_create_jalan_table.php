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
        Schema::create('jalan', function (Blueprint $table) {
            $table->id();
            $table->string('road_name'); // Nama atau deskripsi rute jalan
            $table->string('geometry'); // Geometri rute jalan
            $table->string('condition'); // Kondisi tambahan tentang rute jalan
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalan');
    }
};
