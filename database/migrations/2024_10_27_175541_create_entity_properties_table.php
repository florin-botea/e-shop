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
        Schema::create('entity_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('entity_id');
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->string('default');
            $table->integer('length')->default(11);
            $table->boolean('index')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_properties');
    }
};
