<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('alt');
            $table->string('url');
            $table->string('image_url');
            $table->string('image_path');
            $table->integer('views');
            $table->integer('clicks');
            $table->boolean('active');
            $table->bigInteger('banner_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('banner_category_id')
                ->references('id')
                ->on('banner_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
