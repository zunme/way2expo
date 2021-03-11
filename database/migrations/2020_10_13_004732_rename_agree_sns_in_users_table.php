<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAgreeSnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('agree_sns', 'agree_sms');
        });
        DB::statement("ALTER TABLE users MODIFY agree_sms ENUM('Y', 'N') DEFAULT 'N' COMMENT 'SMS_수신동의_YN'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('agree_sms', 'agree_sns');
        });
        DB::statement("ALTER TABLE users MODIFY agree_sns ENUM('Y', 'N') DEFAULT 'N' COMMENT 'SMS_수신동의_YN'");
    }
}
