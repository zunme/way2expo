<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoothImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booth_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booth_id')->unsigned()->index()->comment('booths.id');
            $table->string('url')->comment('image url');
            $table->smallInteger('sort')->unsigned()->default('1')->index();
            $table->integer('attach_size')->unsigned()->default('0')->comment('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booth_images');
    }
}
