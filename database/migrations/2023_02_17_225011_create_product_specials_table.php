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
        Schema::create('product_specials', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->decimal('price', 20, 4);
            $table->integer('quantity')->comment('when quantity is depleted, special price is removed. -1 means unlimited');
            $table->integer('customer_group_id')->unsigned();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::dropIfExists('product_specials');
    }
};
