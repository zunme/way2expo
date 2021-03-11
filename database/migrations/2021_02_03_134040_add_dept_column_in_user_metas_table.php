<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeptColumnInUserMetasTable extends Migration
{
    public function up()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->string('company_dept',20)->nullable()->comment('부서')->after('company_name');
            $table->string('company_position',50)->comment('직책')->change();
        });
    }

    public function down()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->dropColumn(['company_dept']);
        });
    }
}
