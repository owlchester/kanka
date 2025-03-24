<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('date_format', 5)->nullable()->default(null)->change();
            $table->smallInteger('default_pagination')->nullable()->default(null)->change();
        });

        Illuminate\Support\Facades\DB::statement('UPDATE users SET date_format = null WHERE date_format = \'Y-m-d\'');
        Illuminate\Support\Facades\DB::statement('UPDATE users SET default_pagination = null WHERE default_pagination = 15');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('date_format')->default('Y-m-d')->change();
            $table->smallInteger('default_pagination')->default('15')->change();
        });
    }
};
