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
        Schema::create('undangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mempelai_1');
            $table->string('nama_mempelai_2');
            $table->date('tanggal_acara');
            $table->time('waktu_acara');
            $table->string('tempat');
            $table->string('url_maps')->nullable();
            $table->string('rekening_gift')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangans');
    }
};
