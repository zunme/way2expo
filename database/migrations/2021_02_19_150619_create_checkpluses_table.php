<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckplusesTable extends Migration
{
    public function up()
    {
        Schema::create('checkpluses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->default(0)->comment('users.id');
            $table->enum('type',['R','C','U','F'])->nullable()->default('R')->comment('R:가입전,C:가입,U:변경,F:찾기');
            $table->string('err_code',4)->nullable()->comment('에러코드-0000:정상');
            $table->string('req_seq',30)->comment('CP요청번호');
            $table->enum('auth_type', ['M','C','X','P'])->comment('인증수단');
            $table->string('res_seq', 24)->nullable()->comment('처리결과 고유번호');
            $table->string('name', 50)->nullable()->comment('이름');
            $table->date('birthdate')->nullable()->comment('생년월일YYYYMMDD');
            $table->enum('gender', [0, 1])->nullable()->comment('0: 여성, 1: 남성');
            $table->enum('nationainfo', [0, 1])->nullable()->comment('0: 내국인, 1: 외국인');
            $table->string('di',64)->nullable()->comment('중복가입 확인값');
            $table->string('ci',88)->nullable()->comment('연계정보 확인값');
            $table->string('mobile_co',3)->nullable()->comment('통신사정보');
            $table->string('mobile_no',24)->nullable()->comment('휴대폰번호');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkpluses');
    }
}
