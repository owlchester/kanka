<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Conversation;

class MigrateConversationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedTinyInteger('target_id')
                ->after('slug')
                ->default(Conversation::TARGET_USERS);
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE conversations SET target_id = ' . Conversation::TARGET_CHARACTERS . ' WHERE target = \'characters\'');

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->string('target', 20)
                ->after('slug')
                ->default('users');
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE conversations SET target = \'characters\' WHERE target_id = ' . Conversation::TARGET_CHARACTERS);

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('target_id');
        });
    }
}
