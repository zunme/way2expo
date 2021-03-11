<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expo_id')->comment('박람회_ID')->index();
            $table->bigInteger('user_id')->comment('사용자_ID')->index();
            $table->enum('status', ['R', 'A', 'D'])->default('R')->comment('상태:Ready,Accept,Deny');
            $table->enum('provided_terms_agree', ['Y', 'N'])->default('N')->comment('제3자_동의');
            $table->text('category_text')->nullable()->comment('출품_분야');
            $table->text('category_detail_text')->nullable()->comment('출품_분야_상세');
            $table->string('company_name')->comment('회사_이름');
            $table->string('company_name_eng')->nullable()->comment('회사_이름_영문');
            $table->string('company_zip')->comment('우편번호');
            $table->string('company_address1')->comment('회사_주소1');
            $table->string('company_address2')->comment('회사_주소2');
            $table->string('company_url')->nullable()->comment('회사_홈페이지_URL');
            $table->string('biz_no', 13)->comment('사업자등록번호');
            $table->string('ceo_name')->comment('대표_이름');
            $table->string('ceo_email')->nullable()->comment('대표_이메일');
            $table->string('manager_name')->comment('담당자_이름');
            $table->string('manager_email')->comment('담당자_이메일');
            $table->string('manager_position')->nullable()->comment('담당자_직위');
            $table->string('manager_tel', 50)->comment('담당자_전화번호');
            $table->string('manager_phone', 50)->nullable()->comment('담당자_휴대전화');
            $table->string('manager_fax', 50)->nullable()->comment('담당자_팩스');
            $table->string('tax_manager_name')->comment('세금_담당자_이름');
            $table->string('tax_manager_email')->comment('세금_담당자_이메일');
            $table->string('tax_manager_position')->nullable()->comment('세금_담당자_직위');
            $table->string('tax_manager_tel', 50)->nullable()->comment('세금_담당자_전화번호');
            $table->string('tax_manager_phone', 50)->nullable()->comment('세금_담당자_휴대전화');
            $table->string('tax_manager_fax', 50)->nullable()->comment('세금_담당자_팩스');
            $table->string('attachment_file')->nullable()->comment('첨부파일');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_forms');
    }
}
