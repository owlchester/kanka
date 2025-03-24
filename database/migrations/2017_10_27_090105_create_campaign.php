<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('campaign_user');
        Schema::dropIfExists('campaigns');

        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->string('locale', 5)->nullable();

            $table->string('image', 191)->nullable();
            $table->longText('entry')->nullable();
            $table->text('excerpt')->nullable();

            $table->string('header_image')->nullable();
            $table->string('system', 45)->nullable();

            $table->string('export_path')->nullable();
            $table->date('export_date')->nullable();

            $table->unsignedTinyInteger('visibility_id')->default(App\Models\Campaign::VISIBILITY_PRIVATE);
            $table->boolean('is_featured')->default(false);
            $table->boolean('entity_visibility')->default(false);
            $table->unsignedInteger('visible_entity_count')->default(0);
            $table->boolean('entity_personality_visibility')->default(true);

            $table->text('settings')->nullable();
            $table->text('default_images')->nullable();
            $table->text('ui_settings')->nullable();

            $table->unsignedTinyInteger('boost_count')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->dateTime('featured_until')->nullable();
            $table->text('featured_reason')->nullable();

            $table->unsignedInteger('follower')->default(0);

            $table->boolean('is_hidden')->default(0);

            $table->timestamps();

            $table->index(['visibility_id', 'is_featured', 'visible_entity_count', 'featured_until', 'is_hidden'], 'campaigns_idx');
            $table->index('follower');

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('campaign_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_user');
        Schema::drop('campaigns');
    }
}
