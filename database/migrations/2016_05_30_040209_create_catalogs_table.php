<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('catalog_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('catalog_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['catalog_id','locale']);
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('catalogs');
        Schema::drop('catalog_translations');
    }
}
