<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('useraccount', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }

    public function down()
    {
        Schema::table('useraccount', function (Blueprint $table) {
            $table->string('column_name');
        });
    }
};
