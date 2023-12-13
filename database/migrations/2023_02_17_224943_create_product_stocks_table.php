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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->decimal('price', 20, 4);
            $table->integer('stock_status_id')->unsigned();
            $table->integer('warehouse_id')->unsigned();
            $table->timestamp('available_at')->default(\DB::raw('NOW()'));
            $table->tinyInteger('subtract');
            $table->integer('sort_order');
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
        Schema::dropIfExists('product_stocks');
    }
};
