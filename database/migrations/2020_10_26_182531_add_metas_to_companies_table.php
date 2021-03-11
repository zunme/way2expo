<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetasToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->text('company_info1')->nullable()->comment('회사_소개1')->after('company_image_url');
            $table->text('company_info2')->nullable()->comment('회사_소개2')->after('company_info1');
            $table->string('company_attachment_file_url1')->nullable()->comment('회사_첨부파일1')->after('company_info2');
            $table->string('company_attachment_file_url2')->nullable()->comment('회사_첨부파일2')->after('company_attachment_file_url1');
            $table->string('company_image_url')->change();
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
            $table->dropColumn(['company_info1', 'company_info2', 'company_attachment_file_url1', 'company_attachment_file_url2']);
        });
    }
}
