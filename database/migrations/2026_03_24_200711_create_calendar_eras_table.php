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
        Schema::create('calendar_eras', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('calendar_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->string('name', 191);
            $table->text('description')->nullable();
            $table->string('colour', 12)->nullable();
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->unsignedMediumInteger('start_day')->nullable();
            $table->unsignedMediumInteger('start_month')->nullable();
            $table->integer('start_year');
            $table->unsignedMediumInteger('end_day')->nullable();
            $table->unsignedMediumInteger('end_month')->nullable();
            $table->integer('end_year')->nullable();
            $table->boolean('show_era_dates')->default(false);
            $table->timestamps();

            $table->index('calendar_id');
            $table->index(['start_year', 'start_month', 'start_day']);

            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_eras');
    }
};
