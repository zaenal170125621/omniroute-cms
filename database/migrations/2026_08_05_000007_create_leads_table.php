<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('package')->nullable();
            $table->string('budget')->nullable();
            $table->string('timeline', 50)->nullable();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('baru'); // baru | dihubungi | proposal | deal | batal
            $table->string('source', 20)->default('order'); // order | contact
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
