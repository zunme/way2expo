<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropContactsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('contacts');
    }

    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
}
