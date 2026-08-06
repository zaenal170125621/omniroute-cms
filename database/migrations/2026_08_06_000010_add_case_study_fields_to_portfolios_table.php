<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('year');
            $table->string('duration')->nullable()->after('client_name');
            $table->text('challenge')->nullable()->after('duration');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('result')->nullable()->after('solution');
            $table->json('metrics')->nullable()->after('result');
        });
    }

    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'duration', 'challenge', 'solution', 'result', 'metrics']);
        });
    }
};
