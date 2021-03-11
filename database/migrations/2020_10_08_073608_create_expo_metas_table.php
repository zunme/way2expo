<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpoMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expo_metas', function (Blueprint $table) {
          $table->bigInteger('expo_id')->unsigned()->comment('expos.id');
          $table->integer('visitor_count')->unsigned()->default('0')->comment('방문자수');
          $table->integer('product_count')->unsigned()->default('0')->comment('총제품갯수');
          $table->integer('product_in_cart_count')->unsigned()->default('0')->comment('장바구니에 담긴 갯수');
          $table->integer('booth_count')->unsigned()->default('0')->comment('부스 카운트');
          $table->primary('expo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expo_metas');
    }
}
