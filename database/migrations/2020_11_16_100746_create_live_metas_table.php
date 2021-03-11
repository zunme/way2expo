<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_metas', function (Blueprint $table) {
            $table->bigInteger('live_id')->unsigned()->comment('live.id');
            $table->integer('view_count')->unsigned()->default('0')->comment('누적 시청수');
            $table->integer('like_count')->unsigned()->default('0')->comment('좋아요 수');
            $table->primary('live_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_metas');
    }
}
