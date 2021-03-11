<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_master_user_id')->nullable()->comment('회사_마스터_사용자_아이디')->index();
            $table->string('company_name', 50)->comment('회사_이름');
            $table->string('company_tel1', 50)->comment('회사_연락처1');
            $table->string('company_tel2', 50)->nullable()->comment('회사_연락처2');
            $table->string('company_address1', 50)->nullable()->comment('회사_주소1');
            $table->string('company_address2', 50)->nullable()->comment('회사_주소2');
            $table->integer('company_daum_place_id')->nullable()->comment('회사_다음_주소_검색_아이디');
            $table->string('company_email', 50)->nullable()->comment('회사_이메일');
            $table->string('company_url', 50)->nullable()->comment('회사_홈페이지_URL');
            $table->enum('company_display_status', ['Y', 'N'])->default('Y')->comment('회사_노출_상태YN');
            $table->integer('company_level')->nullable()->default('100')->comment('회사_레벨(100:Default)');
            $table->integer('company_category1')->nullable()->comment('회사_카테고리1');
            $table->integer('company_image_url')->nullable()->comment('회사_대표이미지_URL');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
