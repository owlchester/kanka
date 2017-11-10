<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddViewerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_user', function (Blueprint $table) {
            $table->enum('role', ['member', 'owner', 'viewer'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_user', function (Blueprint $table) {
            $table->enum('role', ['member', 'owner'])->change();
        });
    }
}
