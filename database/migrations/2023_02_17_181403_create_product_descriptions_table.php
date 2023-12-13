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
        Schema::create('product_description', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_description');
    }
};
