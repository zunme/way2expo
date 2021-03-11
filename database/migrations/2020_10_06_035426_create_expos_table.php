<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expos', function (Blueprint $table) {
          $table->id();

          $table->string('expo_code', 20)->unique()->comment('박람회_코드');
          $table->string('expo_name', 50)->comment('박람회_이름');

          $table->timestamp('expo_open_date')->nullable()->comment('박람회_개최_일시');
          $table->timestamp('expo_close_date')->nullable()->comment('박람회_종료_일시');
          $table->timestamp('expo_recruit_start_date')->nullable()->comment('박람회_모집_시작_일시');
          $table->timestamp('expo_recruit_end_date')->nullable()->comment('박람회_모집_종료_일시');
          $table->enum('expo_use_yn', ['Y', 'N'])->default('Y')->comment('박람회_사용여부');

          $table->string('expo_url', 255)->nullable()->comment('박람회_외부_링크_URL');
          $table->string('expo_location', 50)->nullable()->comment('박람회_장소');
          $table->string('expo_image_url', 255)->nullable()->comment('박람회_이미지_URL');
          $table->text('expo_description')->nullable()->comment('박람회_설명');

          $table->string('expo_attachment_file_url', 255)->nullable()->comment('박람회_참가안내서_파일_URL');
          $table->string('expo_info_addr', 50)->nullable()->comment('박람회 주소');
          $table->string('expo_info_email', 20)->nullable()->comment('박람회 이메일');
          $table->string('expo_info_phone', 20)->nullable()->comment('박람회 전화번호');

          $table->json('expo_add_json')->nullable()->comment('박람회_추가_JSON');

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
        Schema::dropIfExists('expos');
    }
}
