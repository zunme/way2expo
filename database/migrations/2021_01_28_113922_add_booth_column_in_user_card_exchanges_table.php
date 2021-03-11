<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoothColumnInUserCardExchangesTable extends Migration
{
    public function up()
    {
        Schema::table('user_card_exchages', function (Blueprint $table) {
            $table->Biginteger('booth_id')->unsigned()->comment('booth.id')->index()->after('company_id');
            $table->enum('read_yn', ['Y', 'N'])->default('N')->comment('확인_YN')->after('use_yn_company');
        });
    }

    public function down()
    {
        Schema::table('user_card_exchages', function (Blueprint $table) {
            $table->dropColumn(['booth_id','read_yn']);
        });
    }
}
