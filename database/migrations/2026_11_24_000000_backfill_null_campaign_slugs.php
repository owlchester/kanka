<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('campaigns')
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->update(['slug' => DB::raw('id')]);
    }

    public function down(): void {}
};
