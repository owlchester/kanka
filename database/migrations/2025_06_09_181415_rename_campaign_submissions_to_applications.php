<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('campaign_submissions', 'applications');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('applications', 'campaign_submissions');
    }
};
