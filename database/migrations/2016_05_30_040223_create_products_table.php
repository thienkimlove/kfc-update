<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catalog_id')->unsigned();

            $table->foreign('catalog_id')
                ->references('id')
                ->on('catalogs')
                ->onDelete('cascade');

            $table->string('image');
            $table->boolean('status')->default(true);

            $table->timestamps();
        });


        Schema::create('product_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('product_id')->unsigned();

            $table->string('title');
            $table->text('desc');
            $table->text('content');

            $table->string('locale')->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
        Schema::drop('product_translations');
    }
}
