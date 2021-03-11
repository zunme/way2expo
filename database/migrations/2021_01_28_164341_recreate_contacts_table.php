<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->comment('회사_이름');
            $table->string('company_tel', 50)->comment('회사_전화');
            $table->string('tel', 50)->nullable()->comment('전화');
            $table->string('email')->comment('이메일');
            $table->string('title')->comment('제목');
            $table->text('message')->comment('내용');
            $table->string('attachment_file_url')->nullable()->comment('첨부파일');
            $table->bigInteger('user_id')->nullable()->comment('user.id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
