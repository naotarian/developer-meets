<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_texts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->comment('0: 表示, 1: 非表示');
            $table->text('slide_text')->nullable()->comment('スライドテキスト');
            $table->integer('sort')->nullable()->comment('int 小さいほうが前');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slide_texts');
    }
}
