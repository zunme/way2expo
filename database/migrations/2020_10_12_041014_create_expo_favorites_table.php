<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpoFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expo_favorites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('users.id')->index();
            $table->bigInteger('expo_id')->unsigned()->comment('expos.id');
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
        Schema::dropIfExists('expo_favorites');
    }
}
