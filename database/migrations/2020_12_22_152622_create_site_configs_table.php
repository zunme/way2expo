<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();
			$table->string('code', 40);
			$table->string('config_type',2)->default('');
			$table->string('title', 100);
			$table->text('val')->nullable();
			$table->enum('use_yn', ['Y', 'N'])->default('Y');
			$table->integer('sortno')->default('0');
            $table->timestamps();
        });
		DB::table('site_configs')->insert(
			array(
				'code' => 'm_banner_booth_area',
				'config_type' =>'M',
				'title' => '모바일 배너 부스 영역',
				'val' => '',
				'use_yn'=>'Y'
			)
		);
		DB::table('site_configs')->insert(
			array(
				'code' => 'm_banner_prd_area',
				'config_type' =>'M',
				'title' => '모바일 메인 제품 영역',
				'val' => '',
				'use_yn'=>'Y'
			)
		);		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_configs');
    }
}
