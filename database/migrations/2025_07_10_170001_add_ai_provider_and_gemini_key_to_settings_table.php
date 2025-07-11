<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ai_provider')->default('openai')->after('ai_key');
            $table->string('gemini_key')->nullable()->after('ai_provider');
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['ai_provider', 'gemini_key']);
        });
    }
}; 