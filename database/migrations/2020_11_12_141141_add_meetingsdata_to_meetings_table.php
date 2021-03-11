<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeetingsdataToMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->integer('duration')->default('60')->comment('duration')->after('meeting_time');
            $table->string('room_id',20)->nullable()->comment('room id')->after('duration');
            $table->string('room_pwd',20)->nullable()->comment('room password')->after('room_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meetings', function (Blueprint $table) {
             $table->dropColumn(['duration','room_id','room_pwd']);
        });
    }
}
