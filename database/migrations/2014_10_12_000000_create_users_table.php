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
            $table->string('user_name')->unique()->nullable()->default(null)->comment('ユーザー名');
            $table->string('icon_image', 256)->nullable()->comment('アイコン画像URL');
            $table->integer('role')->nullable()->default(null)->comment('ユーザー権限,1:管理者');
            $table->string('url_code', 256)->nullable()->comment('URLコード');
            $table->string('comment', 64)->nullable()->comment('一言コメント');
            $table->text('self_introduction')->nullable()->comment('自己紹介');
            $table->string('sex', 16)->nullable()->comment('性別');
            $table->string('engineer_history', 16)->nullable()->comment('エンジニア歴');
            $table->integer('age')->nullable()->comment('年齢');
            $table->string('free_url', 512)->nullable()->comment('フリーURL');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('email_verified')->default(0);
            $table->string('email_verify_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email','deleted_at'],'users_email_index_unique');
            $table->unique(['user_name','deleted_at'],'users_user_name_index_unique');
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
