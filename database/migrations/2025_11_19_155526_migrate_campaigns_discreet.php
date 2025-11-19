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
        $statement = "UPDATE campaigns SET visibility_id = '" . \App\Enums\CampaignVisibility::unlisted->value . "' WHERE visibility_id = '" . \App\Enums\CampaignVisibility::public->value . "' and is_discreet = 1";
        DB::statement($statement);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
