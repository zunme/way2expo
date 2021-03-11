<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->dropColumn('channel_id');
            $table->integer('like_count')->unsigned()->default('0')->comment('좋아요 수')->after('live_status');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->string('channel_id',13)->comment('채널_ID(encrypt(timestamp_booth_id))');
            $table->dropColumn('like_count');
        });
    }
}
