<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $type = EntityType::find(config('entities.ids.bookmark'));
        if (! $type) {
            return;
        }
        $type->code = 'bookmark';
        $type->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
