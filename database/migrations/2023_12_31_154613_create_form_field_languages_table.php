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
        Schema::create('form_field_languages', function (Blueprint $table) {
            $table->id();
            $table->integer('form_field_id');
            $table->integer('language_id');
            $table->string('label');
            $table->string('helper')->nullable();
            $table->string('mention')->nullable();
            $table->string('placeholder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_field_languages');
    }
};
