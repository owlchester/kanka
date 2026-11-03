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
        // MySQL can leave the first table behind when a later FK fails; make a retry clean.
        Schema::dropIfExists('event_participants');
        Schema::dropIfExists('event_groups');

        Schema::create('event_groups', function (Blueprint $table) {
            $table->id();
            // Legacy events/entities use unsigned INT keys rather than BIGINT IDs.
            $table->unsignedInteger('event_id');
            $table->string('name');
            $table->string('colour', 20)->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
        });

        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('entity_id');
            $table->foreignId('group_id')->nullable()->constrained('event_groups')->nullOnDelete();
            $table->string('role')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
            $table->unique(['event_id', 'entity_id']);
            $table->index(['event_id', 'group_id', 'position']);
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
        Schema::dropIfExists('event_groups');
    }
};
