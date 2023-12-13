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
        Schema::create('manufacturer_descriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('manufacturer_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->string('name', 175);
            $table->text('description');
            $table->string('meta_title', 175);
            $table->string('meta_description', 175);
            $table->string('meta_keywords', 175); // todo multi
            $table->string('tags', 175); // todo multi            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturer_descriptions');
    }
};
