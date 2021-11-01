<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesAddIndexesQ22020 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->index('default_order');
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->index(['visibility', 'is_featured', 'visible_entity_count']);
        });
        Schema::table('relations', function (Blueprint $table) {
            $table->index(['attitude', 'relation']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
