<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('has the polymorphic mentionable columns and drops the legacy owner columns', function () {
    expect(Schema::hasColumn('entity_mentions', 'mentionable_type'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'mentionable_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'entity_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'target_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'post_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'timeline_element_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'quest_element_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'campaign_id'))->toBeFalse();
});

it('backfills mentionable_type/mentionable_id from the legacy owner columns on migrate', function () {
    // Roll back just this migration, re-insert rows shaped like the legacy schema,
    // then re-run the migration and assert the backfill mapped each owner type correctly.
    $this->artisan('migrate:rollback', ['--step' => 1])->run();

    DB::table('entities')->insert([
        ['id' => 1, 'campaign_id' => 1, 'type_id' => 1, 'entity_id' => 1, 'name' => 'Target', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'campaign_id' => 1, 'type_id' => 1, 'entity_id' => 2, 'name' => 'Entity Owner', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'campaign_id' => 1, 'type_id' => 1, 'entity_id' => 3, 'name' => 'Post Owner Parent', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('campaigns')->insert([
        'id' => 1, 'name' => 'Test', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('posts')->insert([
        'id' => 1, 'entity_id' => 3, 'name' => 'A post', 'entry' => '', 'position' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);

    // Entity-owned: entity_id set, nothing else.
    DB::table('entity_mentions')->insert([
        ['entity_id' => 2, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);
    // Post-owned: post_id set + entity_id rollup to the post's parent entity.
    DB::table('entity_mentions')->insert([
        ['entity_id' => 3, 'post_id' => 1, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);
    // Campaign-owned: only campaign_id set.
    DB::table('entity_mentions')->insert([
        ['campaign_id' => 1, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);

    $this->artisan('migrate')->run();

    $rows = DB::table('entity_mentions')->orderBy('id')->get();

    expect($rows[0]->mentionable_type)->toBe('App\Models\Entity');
    expect($rows[0]->mentionable_id)->toBe(2);
    expect($rows[0]->entity_id)->toBe(2);

    expect($rows[1]->mentionable_type)->toBe('App\Models\Post');
    expect($rows[1]->mentionable_id)->toBe(1);
    expect($rows[1]->entity_id)->toBe(3);

    expect($rows[2]->mentionable_type)->toBe('App\Models\Campaign');
    expect($rows[2]->mentionable_id)->toBe(1);
    expect($rows[2]->entity_id)->toBeNull();
});
