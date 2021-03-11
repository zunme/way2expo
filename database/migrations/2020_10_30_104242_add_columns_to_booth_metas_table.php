<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBoothMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booth_metas', function (Blueprint $table) {
            $table->integer('favorite_count')->unsigned()->default('0')->comment('즐겨찾기_수')->after('product_in_cart_count');
            $table->integer('meeting_count')->unsigned()->default('0')->comment('미팅신청_수')->after('favorite_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booth_metas', function (Blueprint $table) {
            $table->dropColumn(['favorite_count','meeting_count']);
        });
    }
}
