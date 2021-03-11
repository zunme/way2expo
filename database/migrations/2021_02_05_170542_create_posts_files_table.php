<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_files', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('posts_id')->unsigned()->comment('posts.id');
            $table->string('url')->comment('image url');
			$table->string('org_name')->comment('file name');
            $table->timestamps();
			$table->index(['posts_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_files');
    }
}
