<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStylesAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_styles', function (Blueprint $table) {
            $table->unsignedTinyInteger('order')->nullable();
            $table->dropIndex('campaign_styles_is_enabled_index');
            $table->index(['order', 'is_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_styles', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropIndex('campaign_styles_order_is_enabled_index');
            $table->index('is_enabled');
        });
    }
}
