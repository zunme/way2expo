<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoothMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booth_metas', function (Blueprint $table) {
            $table->bigInteger('booth_id')->unsigned()->comment('booths.id');
            $table->integer('visitor_count')->unsigned()->default('0')->comment('방문자수');
            $table->integer('product_count')->unsigned()->default('0')->comment('총제품갯수');
            $table->integer('product_in_cart_count')->unsigned()->default('0')->comment('장바구니에 담긴 갯수');
            $table->primary('booth_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booth_metas');
    }
}
