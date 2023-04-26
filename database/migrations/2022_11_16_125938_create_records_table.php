<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id('record_id');
            $table->timestamps();
            $table->string('title', 100);
            $table->string('description', 200);
            $table->string('video', 200);
            $table->string('number_speech', 100);
            $table->integer('long_time');
            $table->integer('type_translate');
            $table->integer('type_lang');
            $table->unsignedBigInteger('typelang_id')->default('1');
            $table->boolean('active')->default('0');
        });

        Schema::create('keywords', function (Blueprint $table) {
            $table->id('keyword_id');
            $table->string('word');
            $table->integer('type_lang');
        });

        Schema::create('keywords_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id')->default('0');
            $table->unsignedBigInteger('keyword_id')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
        Schema::dropIfExists('keywords');
        Schema::dropIfExists('keywords_records');
    }
}
