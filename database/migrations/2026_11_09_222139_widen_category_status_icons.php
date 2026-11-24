<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->changeLength(100);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->changeLength(45);
    }

    private function changeLength(int $length): void
    {
        $sequence = DB::getDriverName() === 'sqlite'
            ? DB::table('sqlite_sequence')->where('name', 'category_statuses')->value('seq')
            : null;
        Schema::table('category_statuses', function (Blueprint $table) use ($length) {
            $table->string('icon', $length)->nullable()->change();
        });
        if ($sequence !== null) {
            $current = DB::table('sqlite_sequence')->where('name', 'category_statuses')->value('seq') ?? 0;
            DB::table('sqlite_sequence')->updateOrInsert(['name' => 'category_statuses'], ['seq' => max($sequence, $current)]);
        }
    }
};
