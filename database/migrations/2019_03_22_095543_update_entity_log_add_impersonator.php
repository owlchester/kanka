<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntityLogAddImpersonator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            $table->unsignedInteger('impersonated_by')->nullable();
            $table->foreign('impersonated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            $table->dropColumn('entity_logs_impersonated_by_foreign')->nullable();
            $table->dropForeign('impersonated_by');
        });
    }
}
