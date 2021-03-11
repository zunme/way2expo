<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('userid',20)->comment('아이디')->after('id');
            $table->string('name_en',20)->comment('이름_영문')->after('name');
            $table->string('tel',20)->comment('휴대폰')->after('email');
            $table->string('business_card_front')->nullable()->comment('명함_앞')->after('tel');
            $table->string('business_card_back')->nullable()->comment('명함_뒤')->after('business_card_front');
            $table->integer('country_id')->default(0)->comment('국가_번호')->after('business_card_back');
            $table->integer('company_id')->default(0)->comment('회사_아이디')->index()->after('country_id');
            $table->string('company_part_name',20)->nullable()->comment('부서')->after('company_id');
            $table->string('company_position',20)->nullable()->comment('직급')->after('company_part_name');
            $table->enum('agree_email', ['Y', 'N'])->default('N')->comment('이메일_수신동의_YN')->after('company_position');
            $table->enum('agree_sns', ['Y', 'N'])->default('N')->comment('SMS_수신동의_YN')->after('agree_email');
            $table->char('user_status', 2)->default('Y')->comment('사용자_이용_상태_YN')->after('agree_sns');
            $table->unique('userid');

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
        /*
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['email','userid']);
        });
        */
        Schema::dropIfExists('users');
    }
}
