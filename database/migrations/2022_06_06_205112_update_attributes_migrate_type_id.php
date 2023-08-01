<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Attribute;

class UpdateAttributesMigrateTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')->default(1);
        });

        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_TEXT_ID . " WHERE type = 'block'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_TEXT_ID . " WHERE type = '" . Attribute::TYPE_TEXT . "'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_CHECKBOX_ID . " WHERE type = '" . Attribute::TYPE_CHECKBOX . "'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_SECTION_ID . " WHERE type = '" . Attribute::TYPE_SECTION . "'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_RANDOM_ID . " WHERE type = '" . Attribute::TYPE_RANDOM . "'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_NUMBER_ID . " WHERE type = '" . Attribute::TYPE_NUMBER . "'");
        \Illuminate\Support\Facades\DB::statement("UPDATE attributes SET type_id = " . Attribute::TYPE_LIST_ID . " WHERE type = '" . Attribute::TYPE_LIST . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
