<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLiveBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('live_bans');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('live_bans', function (Blueprint $table) {
            $table->id();
            $table->enum('banned_type',['B','C','U'])->default('B')->comment('B:입장불가, C:채팅금지, U:해제');
            $table->bigInteger('booth_id')->comment('booths.id');
            $table->bigInteger('user_id')->comment('target.users.id');
            $table->bigInteger('created_by_id')->comment('users.id');
            $table->text('memo')->nullable();
            $table->timestamps();
        });
    }
}
