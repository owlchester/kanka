<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConversationsClosed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropIndex('conversations_name_target_is_private_index');
            $table->boolean('is_closed')->default(false)->after('is_private');
            $table->index(['name', 'target', 'is_private', 'is_closed']);
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
            $table->dropIndex('conversations_name_target_is_private_is_closed_index');
            $table->dropColumn('is_closed');
            $table->index(['name', 'target', 'is_private']);
        });
    }
}
