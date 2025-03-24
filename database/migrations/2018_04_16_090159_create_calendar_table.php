<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');

            $table->unsignedInteger('calendar_id')->nullable();

            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false);

            // Settings of the calendar
            $table->text('parameters')->nullable();
            $table->text('months')->nullable();
            $table->text('weekdays')->nullable();
            $table->text('years')->nullable();
            $table->text('seasons')->nullable();
            $table->text('epochs')->nullable();
            $table->text('moons')->nullable();
            $table->string('date')->nullable();
            $table->string('suffix')->nullable();

            $table->text('month_aliases')->nullable();
            $table->text('week_names')->nullable();
            $table->string('reset', 5)->nullable();
            $table->boolean('is_incrementing')->default(false);

            // Leap year stuff, single
            $table->boolean('has_leap_year')->default(false);
            $table->integer('leap_year_amount')->nullable();
            $table->tinyInteger('leap_year_month')->unsigned()->nullable();
            $table->tinyInteger('leap_year_offset')->unsigned()->nullable();
            $table->tinyInteger('leap_year_start')->unsigned()->nullable();

            $table->unsignedTinyInteger('start_offset')->nullable()->default(0);
            $table->boolean('skip_year_zero')->default(false);

            $table->timestamps();

            // Indexes
            $table->index(['name', 'is_private']);
            $table->index(['is_incrementing']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');
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

        $entities = App\Models\Entity::where(['type' => 'calendar'])->get();
        foreach ($entities as $entity) {
            $entity->delete();
        }
    }
}
