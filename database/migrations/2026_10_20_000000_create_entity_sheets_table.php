<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_sheets', function (Blueprint $table) {
            $table->id();
            // entities.id uses increments(), so this must be an unsigned INT rather than BIGINT.
            $table->unsignedInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->string('source', 20);
            $table->string('reference');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['entity_id', 'source', 'reference']);
            $table->index(['entity_id', 'sort_order']);
        });

        DB::table('attributes')->where('name', '_layout')->orderBy('id')->chunkById(500, function ($attributes): void {
            foreach ($attributes as $attribute) {
                DB::table('entity_sheets')->insertOrIgnore([
                    'entity_id' => $attribute->entity_id,
                    'source' => Str::isUuid($attribute->value) ? 'marketplace' : 'legacy',
                    'reference' => $attribute->value,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        DB::table('attributes')->where('name', '_layout')->delete();
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_sheets');
    }
};
