<?php

use App\Enums\CampaignVisibility;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statement = "UPDATE campaigns SET visibility_id = '" . CampaignVisibility::unlisted->value . "' WHERE visibility_id = '" . CampaignVisibility::public->value . "' and is_discreet = 1";
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
