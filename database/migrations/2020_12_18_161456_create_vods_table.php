<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vods', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->string('url')->nullable();
			$table->string('mov_url');
			$table->string('img_url');
			$table->bigInteger('sortno')->default('0')->index();
			$table->enum('use_yn', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
		DB::table('vods')->insert(
			array(
				'title' => 'TEST VOD',
				'url' => '',
				'mov_url'=>'https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_1280_10MG.mp4',
				'img_url'=>'https://storage.googleapis.com/gweb-uniblog-publish-prod/images/earth-4k.max-1000x1000.jpg',
				'sortno'=>1,
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
        Schema::dropIfExists('vods');
    }
}
