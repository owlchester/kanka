<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasIndex('campaigns', 'campaigns_follower_index')) {
                $table->dropIndex('campaigns_follower_index');
            }
            if (Schema::hasColumn('campaigns', 'follower')) {
                $table->dropColumn('follower');
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedInteger('follower')->default(0);
        });
    }
};
