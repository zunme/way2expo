<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnInEntryFormsTable extends Migration
{
    public function up()
    {
        Schema::table('entry_forms', function (Blueprint $table) {
            $table->enum('agree_privacy', ['Y', 'N'])->nullable()->default('Y')->comment('개인정보_수집_동의_YN')->after('status');
            $table->enum('agree_entry', ['Y', 'N'])->nullable()->default('Y')->comment('서비스_신청_동의_YN')->after('agree_privacy');
            $table->dropColumn(['provided_terms_agree']);
            $table->enum('agree_provided', ['Y', 'N'])->nullable()->default('N')->comment('광고_동의_YN')->after('agree_entry');
        });
    }

    public function down()
    {
        Schema::table('entry_forms', function (Blueprint $table) {
            $table->dropColumn(['agree_privacy', 'agree_entry']);
            $table->enum('provided_terms_agree', ['Y', 'N'])->nullable()->default('N')->comment('광고_동의_YN');
        });
    }
}
