<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('charge_id', 45)->nullable();
            $table->string('source_id', 45);
            $table->string('tier', 12);
            $table->string('period', 10);
            $table->string('method', 10);
            $table->unsignedInteger('user_id');
            $table->string('status', 12); // pending, charged, failed
            $table->timestamps();

            $table->index(['source_id', 'charge_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subscription_sources');
    }
}
