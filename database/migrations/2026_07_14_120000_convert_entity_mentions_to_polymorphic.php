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
            $table->dropForeign(['timeline_element_id']);
            $table->dropForeign(['quest_element_id']);
            $table->dropForeign(['campaign_id']);
        });

        // 2023_09_12_200523_migrate_to_posts.php renamed entity_note_id to
        // post_id and then added a *new* foreign key on post_id without
        // dropping the one that came along with the rename (renameColumn()
        // doesn't rename the underlying constraint). MySQL/MariaDB installs
        // therefore have two FK constraints on this column:
        // entity_mentions_entity_note_id_foreign (legacy) and
        // entity_mentions_post_id_foreign (added new). Both must be dropped.
        // SQLite has no named constraints - its grammar matches FK clauses
        // structurally by column, so the first drop removes everything and
        // the second is a no-op that we swallow.
        try {
            Schema::table('entity_mentions', function (Blueprint $table) {
                $table->dropForeign(['post_id']);
            });
        } catch (Throwable) {
            // No FK named entity_mentions_post_id_foreign - nothing to do.
        }

        try {
            Schema::table('entity_mentions', function (Blueprint $table) {
                $table->dropForeign(['entity_note_id']);
            });
        } catch (Throwable) {
            // No FK named entity_mentions_entity_note_id_foreign - nothing to do.
        }

        Schema::table('entity_mentions', function (Blueprint $table) {
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
