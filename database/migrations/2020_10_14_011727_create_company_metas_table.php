<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_metas', function (Blueprint $table) {
            $table->bigInteger('company_id')->comment('회사_아이디');
            $table->text('company_info1')->nullable()->comment('회사_소개1');
            $table->text('company_info2')->nullable()->comment('회사_소개2');
            $table->string('company_attachment_file_url1')->nullable()->comment('회사_첨부파일1');
            $table->string('company_attachment_file_url2')->nullable()->comment('회사_첨부파일2');
            $table->primary('company_id');
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
        Schema::dropIfExists('company_metas');
    }
}
