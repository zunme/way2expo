<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsColumnInExposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expos', function (Blueprint $table) {
            //
            $table->text('privacy_terms_text')->nullable()->comment('개인정보')->after('expo_add_json');
            $table->text('entry_terms_text')->nullable()->comment('참가규정')->after('privacy_terms_text');
            $table->text('provided_terms_text')->nullable()->comment('제3자동의')->after('entry_terms_text');
            $table->string('expo_name')->change();
            $table->string('expo_info_email')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expos', function (Blueprint $table) {
            $table->dropColumn(['privacy_terms_text', 'entry_terms_text', 'provided_terms_text']);
        });
    }
}
