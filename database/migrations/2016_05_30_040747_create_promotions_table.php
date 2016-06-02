<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('image');
            $table->boolean('status')->default(true);

            $table->timestamps();
        });

        Schema::create('promotion_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('promotion_id')->unsigned();

            $table->string('title');
            $table->text('desc');
            $table->text('content');

            $table->string('locale')->index();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promotions');
        Schema::drop('promotion_translations');
    }
}
