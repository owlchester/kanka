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
        Schema::table('subscription_items', function (Blueprint $table) {

            if (Schema::hasColumn('subscription_items', 'stripe_plan')) {
                $table->renameColumn('stripe_plan', 'stripe_price');
            }
            if (! Schema::hasColumn('subscription_items', 'stripe_product')) {
                $table->string('stripe_product')->nullable()->after('stripe_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_items', function (Blueprint $table) {
            $table->renameColumn('stripe_price', 'stripe_plan');
            $table->dropColumn('stripe_product');
        });
    }
};
