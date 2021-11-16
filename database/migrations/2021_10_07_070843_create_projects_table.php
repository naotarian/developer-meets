<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('ユーザーID');
            $table->string('project_name')->comment('プロジェクト名');
            $table->text('project_detail')->comment('プロジェクト詳細');
            $table->string('language')->comment('主要言語');
            $table->string('sub_language')->comment('サブ言語');
            $table->integer('number_of_applicants')->comment('募集人数');
            $table->integer('minimum_experience')->nullable()->comment('最低歴数');
            $table->integer('minimum_years_old')->nullable()->comment('年齢下限');
            $table->integer('max_years_old')->nullable()->comment('年齢上限');
            $table->integer('men_and_women')->comment('男女制限,0:制限なし,1:男性のみ,2女性のみ');
            $table->string('tools')->nullable()->comment('使用ツール');
            $table->string('purpose')->comment('プロジェクト目的');
            $table->integer('status')->comment('ステータス,1:募集中,2:募集停止,3:締め切り,4:開始済み');
            $table->text('remarks')->nullable()->comment('備考');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
