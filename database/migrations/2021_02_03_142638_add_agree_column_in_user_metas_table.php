<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgreeColumnInUserMetasTable extends Migration
{
    public function up()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->enum('agree_service', ['Y', 'N'])->nullable()->default('Y')->comment('서비스_약관_동의_YN')->after('user_id');
            $table->enum('agree_marketing', ['Y', 'N'])->nullable()->default('N')->comment('마케팅_이용_동의_YN')->after('agree_service');
        });
    }

    public function down()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->dropColumn(['agree_service','agree_marketing']);
        });
    }
}
