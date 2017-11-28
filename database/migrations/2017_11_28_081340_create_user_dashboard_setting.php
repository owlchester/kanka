<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDashboardSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_dashboard_settings');

        Schema::create('user_dashboard_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->notNull();

            $table->unsignedTinyInteger('recent_count')->default(5)->notNull();
            $table->boolean('characters')->default(true)->notNull();
            $table->boolean('events')->default(true)->notNull();
            $table->boolean('families')->default(true)->notNull();
            $table->boolean('items')->default(true)->notNull();
            $table->boolean('journals')->default(true)->notNull();
            $table->boolean('locations')->default(true)->notNull();
            $table->boolean('notes')->default(true)->notNull();
            $table->boolean('organisations')->default(true)->notNull();
            $table->boolean('quests')->default(true)->notNull();

            $table->timestamps();

            // Foreign
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        $users = \App\User::all();
        foreach ($users as $user) {
            $setting = new \App\Models\UserDashboardSetting();
            $setting->user_id = $user->id;
            $setting->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_dashboard_settings');
    }
}
