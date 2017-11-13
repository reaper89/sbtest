<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 14:58
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoe_tag', function (Blueprint $table) {
            $table->integer('shoe_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('shoe_id')->references('id')->on('shoes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoe_tag');
    }
}
