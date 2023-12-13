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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_group_id')->unsigned()->default(0);
            $table->string('code')->nullable();
            $table->string('unit_field')->nullable();
            $table->tinyInteger('required')->default(0);            
            $table->string('config')->comment('field json settings')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);            
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
        Schema::dropIfExists('attributes');
    }
};
