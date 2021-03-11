<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBizColumnsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_name_eng')->nullable()->comment('회사_이름_영문')->after('company_name');
            $table->string('company_zip',6)->nullable()->comment('우편번호')->after('company_tel2');
            $table->string('company_attachment_file')->nullable()->comment('사업자등록증_첨부파일')->after('company_attachment_file_name2');
            $table->string('company_ceo_name')->nullable()->comment('대표_이름')->after('company_name_eng');
            $table->string('company_ceo_email')->nullable()->comment('대표_이메일')->after('company_ceo_name');
            $table->string('company_biz_no', 13)->nullable()->comment('사업자등록번호')->after('company_ceo_email');
            $table->string('tax_manager_name')->nullable()->comment('세금_담당자_이름')->after('company_info2');
            $table->string('tax_manager_email')->nullable()->comment('세금_담당자_이메일')->after('tax_manager_name');
            $table->string('tax_manager_position')->nullable()->comment('세금_담당자_직위')->after('tax_manager_email');
            $table->string('tax_manager_tel', 50)->nullable()->comment('세금_담당자_전화번호')->after('tax_manager_position');
            $table->string('tax_manager_phone', 50)->nullable()->comment('세금_담당자_휴대전화')->after('tax_manager_tel');
            $table->string('tax_manager_fax', 50)->nullable()->comment('세금_담당자_팩스')->after('tax_manager_phone');
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
            $table->dropColumn([
                'company_name_eng',
                'company_zip',
                'company_biz_no',
                'company_attachment_file',
                'company_ceo_name',
                'company_ceo_email',
                'tax_manager_name',
                'tax_manager_email',
                'tax_manager_position',
                'tax_manager_tel',
                'tax_manager_phone',
                'tax_manager_fax'
            ]);
        });
    }
}
