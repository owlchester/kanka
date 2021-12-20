<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserLog;

class MigrateUserLogsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_logs', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')
                ->after('user_id')
                ->default(UserLog::TYPE_LOGIN);

            if (!app()->environment('testing')) {
                $table->dropForeign('user_logs_user_id_foreign');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE user_logs SET type_id = ' . UserLog::TYPE_LOGOUT . ' WHERE action = \'logout\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE user_logs SET type_id = ' . UserLog::TYPE_UPDATE . ' WHERE action = \'update\'');

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_logs', function (Blueprint $table) {
            $table->string('action', 10)
                ->after('user_id')
                ->default('login');
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE user_logs SET action = \'logout\' WHERE type_id = ' . UserLog::TYPE_LOGOUT);
        \Illuminate\Support\Facades\DB::statement('UPDATE user_logs SET action = \'update\' WHERE type_id = ' . UserLog::TYPE_UPDATE);

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
