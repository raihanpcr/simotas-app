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
            $table->unsignedBigInteger('kec_id')->nullable()->after('kategori');
            $table->unsignedBigInteger('kel_id')->nullable()->after('kec_id');

            $table->foreign('kec_id')->references('id')->on('kecamatan')->onDelete('set null');
            $table->foreign('kel_id')->references('id')->on('kelurahan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            //
        });
    }
};
