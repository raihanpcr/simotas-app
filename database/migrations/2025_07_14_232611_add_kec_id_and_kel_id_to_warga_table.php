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
        Schema::table('warga', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            // add foreign key
             $table->foreign('kec_id')->references('id')->on('kecamatan')->onDelete('set null');
             $table->foreign('kel_id')->references('id')->on('kelurahan')->onDelete('set null');
        });
    }
};
