<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name')->nullable()->default(null)->comment('ユーザー名');
            $table->string('icon_image', 256)->nullable()->comment('アイコン画像URL');
            $table->integer('role')->nullable()->default(null)->comment('ユーザー権限,1:管理者');
            $table->string('url_code', 256)->nullable()->comment('URLコード');
            $table->string('comment', 64)->nullable()->comment('一言コメント');
            $table->text('self_introduction')->nullable()->comment('自己紹介');
            $table->string('sex', 16)->nullable()->comment('性別');
            $table->string('engineer_history', 16)->nullable()->comment('エンジニア歴');
            $table->integer('age')->nullable()->comment('年齢');
            $table->string('free_url', 512)->nullable()->comment('フリーURL');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->boolean('exist')->nullable()->storedAs('case when deleted_at is null then 1 else null end');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email', 'exist']);
            $table->unique(['user_name', 'exist']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
