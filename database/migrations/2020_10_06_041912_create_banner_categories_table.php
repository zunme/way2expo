<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_categories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->integer('width');
            $table->integer('height');
            $table->timestamps();
        });
        DB::table('banner_categories')->insert(
           array(
               'type' => 'expo_main_header',
               'width' => '600',
               'height' => '200',
           )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_categories');
    }
}
