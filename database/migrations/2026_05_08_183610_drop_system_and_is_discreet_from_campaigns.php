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
            if (Schema::hasIndex('campaigns', 'campaigns_name_system_is_private_index')) {
                $table->dropIndex('campaigns_name_system_is_private_index');
            }
            if (Schema::hasIndex('campaigns', 'campaigns_is_discreet_index')) {
                $table->dropIndex('campaigns_is_discreet_index');
            }
            if (Schema::hasColumn('campaigns', 'system')) {
                $table->dropColumn('system');
            }
            if (Schema::hasColumn('campaigns', 'is_discreet')) {
                $table->dropColumn('is_discreet');
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('system')->nullable();
            $table->boolean('is_discreet')->default(false);
        });
    }
};
