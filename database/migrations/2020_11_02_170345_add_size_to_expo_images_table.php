<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeToExpoImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expo_images', function (Blueprint $table) {
            $table->integer('attach_size')->unsigned()->default('0')->comment('size')->after('sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expo_images', function (Blueprint $table) {
          $table->dropColumn(['attach_size']);
        });
    }
}
