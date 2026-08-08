<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('creature_location');
        Schema::dropIfExists('organisation_location');
        Schema::dropIfExists('race_location');
    }

    public function down(): void
    {
        // The data was migrated to entity_locations and cannot be restored here.
    }
};
