<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CharacterTrait;

class MigrateCharacterTraitsEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_traits', function (Blueprint $table) {
            $table->unsignedTinyInteger('section_id')
                ->after('section')
                ->default(CharacterTrait::SECTION_APPEARANCE);
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE character_traits SET section_id = ' . CharacterTrait::SECTION_PERSONALITY . ' WHERE section = \'personality\'');

        Schema::table('character_traits', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_traits', function (Blueprint $table) {
            $table->string('section_id', 12)
                ->after('section_id')
                ->default('appearance');
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE character_traits SET section = \'personality\' WHERE section_id = ' . CharacterTrait::SECTION_PERSONALITY);

        Schema::table('character_traits', function (Blueprint $table) {
            $table->dropColumn('section_id');
        });
    }
}
