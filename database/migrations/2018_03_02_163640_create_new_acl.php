<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Each campaign can have several custom roles
        Schema::dropIfExists('campaign_roles');
        Schema::create('campaign_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('campaign_id')->unsigned();

            $table->boolean('is_admin')->default(false);
            $table->boolean('is_public')->default(false);

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Indexes
            $table->index(['name']);
        });

        // Each campaign member can have several roles
        Schema::dropIfExists('campaign_role_users');
        Schema::create('campaign_role_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_role_id')->references('id')->on('campaign_roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Each role can have default permissions for all the elements
        Schema::dropIfExists('campaign_permissions');
        Schema::create('campaign_permissions', function (Blueprint $table) {
            $table->increments('id');

            // A permission can either be related to a role
            $table->integer('campaign_role_id')->unsigned()->nullable();

            // Or be related to a user
            $table->integer('user_id')->unsigned()->nullable();

            // A key is a simple concept that allows us to easily get everything
            // browse_characters => Allow browsing characters
            // edit_locations_4 => Allow editing location id 4
            // $table->string('key', 191);

            // The table name
            // $table->string('table_name', 191);

            $table->boolean('access')->default(true);

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_role_id')->references('id')->on('campaign_roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            // $table->index(['key', 'table_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
