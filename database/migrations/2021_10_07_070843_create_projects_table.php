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
            $table->string('project_name', 256)->nullable()->comment('プロジェクト名');
            $table->text('project_detail')->nullable()->comment('プロジェクト詳細');
            $table->string('url_code', 256)->nullable()->comment('URLコード');
            $table->text('project_image', 256)->nullable()->comment('プロジェクト画像');
            $table->string('language', 128)->nullable()->comment('主要言語');
            $table->string('sub_language', 128)->nullable()->comment('サブ言語');
            $table->integer('number_of_application')->nullable()->comment('募集人数');
            $table->integer('minimum_experience')->nullable()->comment('最低歴数');
            $table->integer('minimum_years_old')->nullable()->comment('年齢下限');
            $table->integer('max_years_old')->nullable()->comment('年齢上限');
            $table->string('men_and_women', 16)->nullable()->comment('男女制限');
            $table->string('tools', 16)->nullable()->comment('使用ツール');
            $table->string('purpose', 16)->nullable()->comment('プロジェクト目的');
            $table->string('work_frequency', 16)->nullable()->comment('作業頻度');
            $table->string('status', 16)->nullable()->comment('ステータス');
            $table->text('remarks')->nullable()->comment('備考');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
