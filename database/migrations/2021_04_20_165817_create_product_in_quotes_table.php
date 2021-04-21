<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_in_quotes', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('quote_id');
            $table->foreignId('product_id');
            $table->integer('count');
            $table->timestamps();

            $table->foreign('quote_id')
                ->references('id')->on('quotes')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_in_quotes');
    }
}
