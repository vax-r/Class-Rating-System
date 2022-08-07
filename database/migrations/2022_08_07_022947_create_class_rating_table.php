<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classRating', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("class_id")->comment("課號");
            $table->string("commenter")->comment("評價者");
            $table->tinyInteger("rating")->comment("課程評價");
            $table->text("comment")->comment("留言");

            $table->unique(["class_id","commenter"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classRating');
    }
}
