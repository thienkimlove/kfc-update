<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            $table->string('image');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('restaurant_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();

            $table->string('title');
            $table->text('desc');
            $table->text('content');

            $table->string('locale')->index();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('restaurants');
        Schema::drop('restaurant_translations');
    }
}
