<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->comment('기업_ID')->index();
            $table->bigInteger('user_id')->comment('사용자_ID')->index();
            $table->bigInteger('booth_id')->comment('부스_ID');
            $table->text('message')->comment('메시지');
            $table->enum('read_yn', ['Y', 'N'])->default('N')->comment('읽음_YN');
            $table->enum('display_yn', ['Y', 'N'])->default('Y')->comment('노출_YN');
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
        Schema::dropIfExists('contacts');
    }
}
