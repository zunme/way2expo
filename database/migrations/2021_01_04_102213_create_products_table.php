<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('expo_id')->default('0')->comment('박람회_ID')->index();
			$table->bigInteger('booth_id')->default('0')->comment('부스_ID')->index();
			$table->string('prd_title');
			$table->string('prd_url')->nullable();
			$table->string('prd_img1')->nullable();
			$table->string('prd_img2')->nullable();
			$table->string('prd_img3')->nullable();
			$table->string('prd_img4')->nullable();
			$table->integer('prd_org_price')->nullable();
			$table->integer('prd_price')->nullable();
			$table->integer('prd_price_percent')->nullable();
			$table->text('prd_description')->nullable();
			$table->enum('prd_viewprice', ['Y', 'N'])->default('Y')->comment('가격 display 여부');
			$table->enum('prd_use_yn', ['Y', 'N'])->default('Y')->comment('사용여부_어드민');
			$table->enum('prd_display_yn', ['Y', 'N'])->default('Y')->comment('노출여부');
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
        Schema::dropIfExists('products');
    }
}
