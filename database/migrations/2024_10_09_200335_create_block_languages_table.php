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
        Schema::create('block_languages', function (Blueprint $table) {
            $table->id();
            $table->string('module')->index();
            $table->string('block')->index();
            $table->string('code')->index();
            $table->string('lang')->index();
            $table->text('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_languages');
    }
};
