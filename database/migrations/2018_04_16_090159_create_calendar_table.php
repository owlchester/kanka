<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('calendars');
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->string('name')->notNull();
            $table->string('slug')->nullable();
            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false)->notNull();

            // Settings of the calendar
            $table->text('parameters')->nullable();
            $table->text('months')->nullable();
            $table->text('weekdays')->nullable();
            $table->text('years')->nullable();
            $table->text('seasons')->nullable();
            $table->string('date')->nullable();
            $table->string('suffix')->nullable();

            // Leap year stuff, single
            $table->boolean('has_leap_year')->default(false);
            $table->tinyInteger('leap_year_amount')->unsigned()->nullable();
            $table->tinyInteger('leap_year_month')->unsigned()->nullable();
            $table->tinyInteger('leap_year_offset')->unsigned()->nullable();
            $table->tinyInteger('leap_year_start')->unsigned()->nullable();


            $table->timestamps();

            // Indexes
            $table->index(['name', 'is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('calendars')->default(true);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('calendars');
        });

        $entities = \App\Models\Entity::where(['type' => 'calendar'])->get();
        foreach ($entities as $entity) {
            $entity->delete();
        }

    }
}
