<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitCountToLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->integer('visitor_count')->default('0')->comment('방문자수')->after('live_status');
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
            $table->dropColumn(['download_url', 'gid', 'path']);
        });
    }
}
