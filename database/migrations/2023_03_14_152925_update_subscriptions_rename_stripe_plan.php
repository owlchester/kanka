<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // New installs have the correct field name
        if (Schema::hasColumn('subscriptions', 'stripe_price')) {
            return;
        }
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->renameColumn('stripe_plan', 'stripe_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->renameColumn('stripe_price', 'stripe_plan');
        });
    }
};
