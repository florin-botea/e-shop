<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('model', 20)->nullable();
            $table->string('sku', 20)->nullable();
            $table->string('upc', 20)->nullable();
            $table->string('ean', 20)->nullable();
            $table->string('jan', 20)->nullable();
            $table->string('isbn', 20)->nullable();
            $table->string('mpn', 20)->nullable();
            $table->integer('outstock_status_id')->unsigned()->default(0);
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
