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
        Schema::create('undangan_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained()->onDelete('cascade');
            $table->text('description_mempelai_1')->nullable();
            $table->text('description_mempelai_2')->nullable();
            $table->text('story_1')->nullable();
            $table->date('tgl_story_1')->nullable();
            $table->text('story_2')->nullable();
            $table->date('tgl_story_2')->nullable();
            $table->text('story_3')->nullable();
            $table->date('tgl_story_3')->nullable();
            $table->longText('music')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan_contents');
    }
};
