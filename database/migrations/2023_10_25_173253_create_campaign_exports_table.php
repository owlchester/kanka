<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {


        $test = 'Create a new table `campaign_exports` that has an id, 
        campaign_id, 
        created_by, 
        size, 
        type tinyint, 
        timestamps, tinyint status. 
        Campaign/user foreign key. 
        Index on status. 
        User id needs to be nullable, for when we start the process in the console. 
        Instead of cascadeOnDelete, use nullOnDelete instead 
        (so someone who deletes their data, we still have a trace of the export)';

        Schema::create('campaign_exports', function (Blueprint $table) {

            $table->id();
            $table->unsignedInteger('campaign_id');


            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->mediumText('config')->nullable();

            $table->unsignedInteger('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();



            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name', 100);

            $table->index('campaign_id');
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_exports');

    }
};
