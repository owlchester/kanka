<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventoryFreeText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->nullable()->change();
            $table->string('name', 45)->nullable();
            $table->boolean('is_equipped')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->change();
            $table->dropColumn('name');
            $table->dropColumn('is_equipped');
        });
    }
}
