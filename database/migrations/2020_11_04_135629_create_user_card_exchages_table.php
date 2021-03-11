<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCardExchagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_card_exchages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('users.id')->index();
            $table->bigInteger('company_id')->unsigned()->comment('company.id')->index();
            $table->text('message')->nullable();
            $table->enum('use_yn_sender', ['Y', 'N'])->default('Y')->comment('보낸사람이 결정');
            $table->enum('use_yn_company', ['Y', 'N'])->default('Y')->comment('받는이가 결정');
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
        Schema::dropIfExists('user_card_exchages');
    }
}
