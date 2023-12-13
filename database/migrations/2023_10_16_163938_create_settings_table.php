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
        Schema::defaultStringLength(191);
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('store_id');
            $table->string('code');
            $table->string('key');
            $table->longText('value');
            $table->tinyInteger('is_json')->default(0);
            
            // $table->primary(['store_id', 'code', 'key'], 'unique_combo'); todo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
