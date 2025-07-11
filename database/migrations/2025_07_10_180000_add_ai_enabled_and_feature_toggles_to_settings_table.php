<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('enabled')->default(false)->after('gemini_key');
            $table->boolean('enable_description')->default(true)->after('enabled');
            $table->boolean('enable_reply')->default(true)->after('enable_description');
            $table->boolean('enable_solution')->default(true)->after('enable_reply');
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['enabled', 'enable_description', 'enable_reply', 'enable_solution']);
        });
    }
}; 