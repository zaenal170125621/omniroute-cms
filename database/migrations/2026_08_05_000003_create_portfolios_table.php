<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // company-profile | e-commerce | landing-page | web-app
            $table->string('cover_image')->nullable();
            $table->string('cover_color', 20)->default('#0A0A0A');
            $table->text('description');
            $table->string('link')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('year', 10)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
};
