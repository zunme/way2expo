<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code1',2);
            $table->integer('code2')->unsigned()->default(0);
            $table->string('full_code',4);
            $table->string('name');
            $table->unsignedInteger('parent_id')->nullable();
            $table->enum('display_yn', ['Y', 'N'])->default('Y')->comment('노출여부');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
