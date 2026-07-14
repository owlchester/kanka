<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->string('mentionable_type')->nullable()->after('id');
            $table->unsignedBigInteger('mentionable_id')->nullable()->after('mentionable_type');
        });

        DB::table('entity_mentions')
            ->whereNotNull('entity_id')
            ->whereNull('post_id')
            ->whereNull('timeline_element_id')
            ->whereNull('quest_element_id')
            ->update([
                'mentionable_type' => 'App\Models\Entity',
                'mentionable_id' => DB::raw('entity_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('post_id')
            ->update([
                'mentionable_type' => 'App\Models\Post',
                'mentionable_id' => DB::raw('post_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('timeline_element_id')
            ->update([
                'mentionable_type' => 'App\Models\TimelineElement',
                'mentionable_id' => DB::raw('timeline_element_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('quest_element_id')
            ->update([
                'mentionable_type' => 'App\Models\QuestElement',
                'mentionable_id' => DB::raw('quest_element_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('campaign_id')
            ->update([
                'mentionable_type' => 'App\Models\Campaign',
                'mentionable_id' => DB::raw('campaign_id'),
            ]);

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->index(['mentionable_type', 'mentionable_id']);

            $table->dropForeign(['entity_id']);
            $table->dropForeign(['post_id']);
            $table->dropForeign(['timeline_element_id']);
            $table->dropForeign(['quest_element_id']);
            $table->dropForeign(['campaign_id']);

            $table->dropColumn(['post_id', 'timeline_element_id', 'quest_element_id', 'campaign_id']);
        });
    }

    public function down(): void
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->integer('post_id')->unsigned()->nullable();
            $table->unsignedBigInteger('timeline_element_id')->nullable();
            $table->unsignedBigInteger('quest_element_id')->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
        });

        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\Post')
            ->update(['post_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\TimelineElement')
            ->update(['timeline_element_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\QuestElement')
            ->update(['quest_element_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\Campaign')
            ->update(['campaign_id' => DB::raw('mentionable_id')]);

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('timeline_element_id')->references('id')->on('timeline_elements')->onDelete('cascade');
            $table->foreign('quest_element_id')->references('id')->on('quest_elements')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->dropIndex(['mentionable_type', 'mentionable_id']);
            $table->dropColumn(['mentionable_type', 'mentionable_id']);
        });
    }
};
