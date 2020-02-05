<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityVotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::dropIfExists('community_vote_ballots');
//        Schema::dropIfExists('community_votes');

        Schema::create('community_votes', function (Blueprint $table) {
            $table->increments('id');
            //$table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('visible_at')->nullable();

            $table->string('name', 45);
            $table->mediumText('content');
            $table->text('excerpt');
            $table->text('options')->nullable();

            $table->timestamps();

            $table->index(['published_at', 'visible_at']);
        });

        Schema::create('community_vote_ballots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('community_vote_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('vote', 191);
            $table->timestamps();

            $table->foreign('community_vote_id')->references('id')->on('community_votes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('community_vote_ballots');
        Schema::drop('community_votes');
    }
}
