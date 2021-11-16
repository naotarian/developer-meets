<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSoftDeletesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->dropUnique('users_email_unique');
            $table->dropUnique('users_user_name_unique');
            $table->unique(['email','deleted_at'],'users_email_unique');
            $table->unique(['user_name','deleted_at'],'users_user_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropUnique('users_user_name_unique');
            $table->dropUnique('users_email_unique');
            $table->unique('email','users_email_unique');
            $table->unique('user_name','users_user_name_unique');
        });
    }
}
