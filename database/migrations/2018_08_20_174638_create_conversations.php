<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->string('name', 191);
            $table->string('image', 255)->nullable();
            $table->string('type', 45)->nullable();
            $table->unsignedTinyInteger('target_id')
                ->default(App\Models\Conversation::TARGET_USERS);

            $table->boolean('is_private')->default(false);
            $table->boolean('is_closed')->default(false);

            $table->timestamps();

            $table->index(['name', 'is_private', 'is_closed']);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('conversation_id');
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('conversation_id');
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->longText('message')->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->index('created_at');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('conversations')->default(true);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversation_messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('conversations');
        });

    }
}
