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
            $table->string('user_name')->comment('ユーザー名');
            $table->text('icon_image')->nullable()->comment('アイコン画像URL');
            $table->string('comment')->nullable()->comment('一言コメント');
            $table->text('self_introduction')->nullable()->comment('自己紹介');
            $table->integer('friends_id')->nullable()->comment('フレンドのid');
            $table->integer('sex')->comment('1:男性,2:女性,3その他');
            $table->integer('engineer_history')->nullable()->comment('エンジニア歴');
            $table->integer('age')->comment('年齢');
            $table->string('free_url')->nullable()->comment('フリーURL');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
