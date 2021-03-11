<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reciever_id')->comment('받는 사용자 users.id')->index();
            $table->bigInteger('sender_id')->default('0')->comment('보낸 사용자 users.id');
            $table->json('data')->comment('NOTI 내용');
            $table->enum('noti_read', ['Y', 'N'])->default('N');
            $table->enum('noti_status', ['R', 'E' , 'D'])->default('R');
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
        Schema::dropIfExists('notifications');
    }
}
