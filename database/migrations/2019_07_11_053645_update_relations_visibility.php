<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationsVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relations', function (Blueprint $table) {
            $table->string('visibility')->default('all');
            $table->unsignedInteger('mirror_id')->nullable();
            $table->tinyInteger('attitude')->default(0)->nullable();
            $table->boolean('is_star')->default(false);

            $table->index(['visibility']);
            $table->index(['is_star'], 'relations_is_star_idx');

            // Default is to simply unlink relatons
            $table->foreign('mirror_id')->references('id')->on('relations')->onDelete('set null');
        });

        DB::statement("UPDATE relations SET visibility = 'admin' WHERE is_private = 1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relations', function (Blueprint $table) {
            $table->dropForeign('relations_mirror_id_foreign');

            $table->dropColumn('visibility');
            $table->dropColumn('attitude');
            $table->dropColumn('is_star');
            $table->dropColumn('mirror_id');
        });
    }
}
