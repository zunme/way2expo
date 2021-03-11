<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_attachment_file_name1')->nullable()->comment('회사_첨부파일_이름1')->after('company_attachment_file_url1');
            $table->string('company_attachment_file_name2')->nullable()->comment('회사_첨부파일_이름2')->after('company_attachment_file_url2');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['company_attachment_file_name1','company_attachment_file_name2']);
        });
    }
}
