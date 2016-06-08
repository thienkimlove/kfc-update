<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableRestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {

            $table->string('ext_phone')->nullable();

            $table->boolean('wifi')->default(false);
            $table->boolean('round_the_clock')->default(false);
            $table->boolean('car_distribution')->default(false);
            $table->boolean('corporative')->default(false);
            $table->boolean('degustation')->default(false);
            $table->boolean('excursion')->default(false);
            $table->boolean('takeaway')->default(false);
            $table->boolean('breakfast')->default(false);

            
            $table->string('breakfast_time')->nullable();

            $table->smallInteger('count_people_in_excursion')->default(0);
            $table->smallInteger('count_people_in_degustation')->default(0);

            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn([
                'ext_phone',
                'wifi',
                'round_the_clock',
                'car_distribution',
                'corporative',
                'degustation',
                'excursion',
                'takeaway',
                'breakfast',
                'breakfast_time',
                'count_people_in_excursion',
                'count_people_in_degustation',
                'lat',
                'lon'
            ]);
        });
    }
}
