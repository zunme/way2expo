<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cards', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->comment('users.id');
            $table->string('card_name', 50)->comment('이름');
            $table->string('card_tel', 20)->comment('전화번호');
            $table->string('card_email', 50)->nullable()->comment('이메일');
            $table->string('card_company', 50)->nullable()->comment('회사');
            $table->string('card_dept', 50)->nullable()->comment('부서');
            $table->string('card_position', 50)->nullable()->comment('직책');
            $table->string('card_addr')->nullable()->comment('주소');
            $table->string('card_homepage')->nullable()->comment('홈페이지');
            $table->enum('card_use', ['Y', 'N'])->default('Y')->comment('사용여부');
            $table->timestamps();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_cards');
    }
}
