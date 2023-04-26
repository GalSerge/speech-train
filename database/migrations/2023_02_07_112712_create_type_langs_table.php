<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_langs', function (Blueprint $table) {
            $table->id('typelang_id');
            $table->string('title');
        });

        DB::table('type_langs')->insert(
            [
                [
                    'typelang_id' => 1,
                    'title' => 'Русский'
                ],
                [
                    'typelang_id' => 2,
                    'title' => 'English'
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_langs');
    }
}
