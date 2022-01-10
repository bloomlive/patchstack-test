<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVulnerabilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->json('factors')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vulnerabilities');
    }
}
