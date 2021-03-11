<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->text('download_url')->nullable()->after('like_count');
            $table->string('gid', 20)->nullable()->after('download_url');
            $table->string('path')->nullable()->after('gid');
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
