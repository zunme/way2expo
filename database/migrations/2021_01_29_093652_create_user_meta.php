<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMeta extends Migration
{
    public function up()
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->bigInteger('user_id')->primary()->comment('user.id');
            $table->tinyInteger('gender')->nullable()->comment('성별:0여성,1남성');
            $table->string('area', 20)->nullable()->comment('지역');
            $table->integer('age')->nullable()->comment('연령대');
            $table->date('birthdate')->nullable()->comment('생년월일');
            $table->bigInteger('category_pid1')->nullable()->comment('categories.parent_id');
            $table->bigInteger('category_id1')->nullable()->comment('categories.id');
            $table->bigInteger('category_pid2')->nullable()->comment('categories.parent_id');
            $table->bigInteger('category_id2')->nullable()->comment('categories.id');
            $table->bigInteger('category_pid3')->nullable()->comment('categories.parent_id');
            $table->bigInteger('category_id3')->nullable()->comment('categories.id');
            $table->string('purpose_viewing', 30)->nullable()->comment('관람목적');
            $table->string('industry', 20)->nullable()->comment('업종');
            $table->string('company_name', 50)->nullable()->comment('기업명');
            $table->string('company_position', 50)->nullable()->comment('부서/직책');
            $table->string('company_image_url')->nullable()->comment('기업_대표이미지');
            $table->string('company_site')->nullable()->comment('기업_홈페이지');
            $table->string('company_tel', 50)->nullable()->comment('기업_전화번호');
            $table->string('company_zip', 6)->nullable()->comment('우편번호');
            $table->string('company_address1', 50)->nullable()->comment('기업_주소1');
            $table->string('company_address2', 50)->nullable()->comment('기업_주소1');
            $table->text('intro')->nullable()->comment('소개글');
            $table->string('company_attachment_file_url')->nullable()->comment('소개자료');
            $table->string('company_attachment_file_name')->nullable()->comment('소개자료');
            $table->timestamps();
        });

        $ids = DB::table('users')->pluck('id');
        foreach ($ids as $id) {
            \App\Models\UserMeta::create(['user_id'=>$id]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('user_metas');
    }
}
