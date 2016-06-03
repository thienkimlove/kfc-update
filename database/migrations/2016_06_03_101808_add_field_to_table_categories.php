<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_translations', function (Blueprint $table) {
            $table->text('content');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('display_as_post')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_translations', function (Blueprint $table) {
            $table->dropColumn('content');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('display_as_post')->change();
        });
    }
}
