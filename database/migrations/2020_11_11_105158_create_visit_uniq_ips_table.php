<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitUniqIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_uniq_ips', function (Blueprint $table) {
            $table->string('visitable_type', 50);
            $table->bigInteger('visitable_id')->unsigned();
            $table->date('today');
            $table->integer('cnt')->unsigned();
            $table->primary(['visitable_type','visitable_id','today']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_uniq_ips');
    }
}
