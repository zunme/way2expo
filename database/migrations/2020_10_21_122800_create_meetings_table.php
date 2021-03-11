<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booth_id')->comment('부스_ID')->index();
            $table->bigInteger('user_id')->comment('신청인')->index();
            $table->date('meeting_date')->comment('날짜');
            $table->tinyInteger('meeting_time')->comment('시간');
            $table->enum('meeting_status',['R','A','D'])->default('R')->comment('상태:Ready,Accept,Deny');
            $table->text('meeting_msg')->nullable()->comment('내용');
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
        Schema::dropIfExists('meetings');
    }
}
