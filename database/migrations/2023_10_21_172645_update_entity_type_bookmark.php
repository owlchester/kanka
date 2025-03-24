<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $type = App\Models\EntityType::find(config('entities.ids.bookmark'));
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
