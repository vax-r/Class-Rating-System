<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classInfo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("class_id")->unique()->comment("課號");
            $table->string("class_name")->comment("課程名稱");
            $table->string("teacher")->nullable()->comment("授課老師");
            $table->integer("credit")->comment("學分");
            $table->string("Required")->comment("必/選修");
            $table->text("outline")->nullable()->comment("課程綱要");
            $table->double("rating")->comment("平均評分");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classInfo');
    }
}
