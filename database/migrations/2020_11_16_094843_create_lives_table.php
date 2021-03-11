<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lives', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booth_id')->comment('부스_ID')->index();
            $table->string('channel_id',13)->comment('채널_ID(encrypt(timestamp_booth_id))');
            $table->enum('live_status',['R','O','C'])->default('R')->comment('상태:Ready,Open,Close');
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
        Schema::dropIfExists('lives');
    }
}
