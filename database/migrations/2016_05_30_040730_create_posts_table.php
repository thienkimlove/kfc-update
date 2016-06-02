<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->string('image');
            $table->boolean('status')->default(true);            
            $table->timestamps();
        });

        Schema::create('post_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('post_id')->unsigned();

            $table->string('title');
            $table->text('desc');
            $table->text('content');

            $table->string('locale')->index();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
        Schema::drop('post_translations');
    }
}
