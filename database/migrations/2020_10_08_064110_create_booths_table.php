<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoothsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booths', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('company_id')->default('0')->comment('회사_ID')->index();
            $table->bigInteger('expo_id')->default('0')->comment('박람회_ID')->index();
            $table->string('booth_image_url', 255)->nullable()->comment('부스_이미지_URL');
            $table->string('booth_mobile_image_url', 255)->nullable()->comment('부스_모바일_이미지_URL');
            $table->string('booth_movtype', 10)->nullable()->comment('동영상선택');
            $table->string('booth_youtube_url', 255)->nullable()->comment('부스_유투브링크_URL');
            $table->string('booth_mp4_url', 50)->nullable()->comment('부스_동영상_업로드_URL');
            $table->string('booth_title', 50)->nullable()->comment('부스_타이틀');
            $table->text('booth_intro')->nullable()->comment('부스_설명');
            $table->enum('booth_use_yn', ['Y', 'N'])->default('Y')->comment('부스_사용여부');
            $table->enum('booth_display_yn', ['Y', 'N'])->default('Y')->comment('부스_노출여부');
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
        Schema::dropIfExists('booths');
    }
}
