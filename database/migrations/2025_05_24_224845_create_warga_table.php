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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('umur');
            $table->string('alamat');
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
