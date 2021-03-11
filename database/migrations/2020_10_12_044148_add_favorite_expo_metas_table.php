<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFavoriteExpoMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('expo_metas', function (Blueprint $table) {
          $table->integer('favorite_count')->unsigned()->default('0')->comment('즐겨찾기수')->after('product_in_cart_count');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('expo_metas', function (Blueprint $table) {
          $table->dropColumn('favorite_count');
      });
    }
}
