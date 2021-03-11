<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoothFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booth_favorites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('사용자_아이디')->index();
            $table->bigInteger('booth_id')->comment('부스_아이디');
            $table->string('url')->nullable()->comment('URL');
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
        Schema::dropIfExists('booth_favorites');
    }
}
