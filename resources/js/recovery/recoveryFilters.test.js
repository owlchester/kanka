import { describe, it } from 'node:test';
import assert from 'node:assert/strict';
import {
    buildDeletedByOptions,
    buildTypeOptions,
    elementKey,
    filterAndSortModels,
} from './recoveryFilters.js';

const NOW = 1_700_000_000;

const sampleModels = [
    {
        id: 1,
        type: 'entity',
        type_id: 1,
        type_name: 'Character',
        name: 'Aldric Stormborn',
        parent_name: null,
        deleted_by: 10,
        deleted_name: 'Alice',
        deleted_at_timestamp: NOW - 3600, // 1 hour ago
        days_left: 29,
        position: 0,
    },
    {
        id: 1,
        type: 'post',
        type_id: 0,
        type_name: 'Article',
        name: 'Backstory',
        parent_name: 'Aldric Stormborn',
        deleted_by: 20,
        deleted_name: 'Bob',
        deleted_at_timestamp: NOW - 3 * 86400, // 3 days ago
        days_left: 27,
        position: 1,
    },
    {
        id: 2,
        type: 'entity',
        type_id: 2,
        type_name: 'Location',
        name: 'Crystal Spire',
        parent_name: null,
        deleted_by: 10,
        deleted_name: 'Alice',
        deleted_at_timestamp: NOW - 26 * 86400, // 26 days ago
        days_left: 4,
        position: 2,
    },
    {
        id: 3,
        type: 'entity',
        type_id: 2,
        type_name: 'Location',
        name: 'Old Tavern',
        parent_name: null,
        deleted_by: null,
        deleted_name: 'Unknown',
        deleted_at_timestamp: NOW - 35 * 86400, // 35 days ago
        days_left: 0,
        position: 3,
    },
];

describe('elementKey', () => {
    it('distinguishes entity and post with the same numeric id', () => {
        assert.equal(elementKey(sampleModels[0]), 'entity-1');
        assert.equal(elementKey(sampleModels[1]), 'post-1');
        assert.notEqual(elementKey(sampleModels[0]), elementKey(sampleModels[1]));
    });
});

describe('buildDeletedByOptions', () => {
    it('groups and sorts unique deleters with counts including null deleted_by', () => {
        const options = buildDeletedByOptions(sampleModels);

        assert.deepEqual(options, [
            { value: '10', label: 'Alice', count: 2 },
            { value: '20', label: 'Bob', count: 1 },
            { value: 'unknown', label: 'Unknown', count: 1 },
        ]);
    });
});

describe('buildTypeOptions', () => {
    it('groups and sorts unique types with counts', () => {
        const options = buildTypeOptions(sampleModels);

        assert.deepEqual(options, [
            { value: 'post:0', label: 'Article', count: 1 },
            { value: 'entity:1', label: 'Character', count: 1 },
            { value: 'entity:2', label: 'Location', count: 2 },
        ]);
    });
});

describe('filterAndSortModels', () => {
    it('filters by search across name, parent_name, type_name, and deleted_name', () => {
        assert.equal(filterAndSortModels(sampleModels, { search: 'crystal', nowSeconds: NOW }).length, 1);
        assert.equal(filterAndSortModels(sampleModels, { search: 'aldric', nowSeconds: NOW }).length, 2); // entity + post with parent_name
        assert.equal(filterAndSortModels(sampleModels, { search: 'bob', nowSeconds: NOW }).length, 1);
        assert.equal(filterAndSortModels(sampleModels, { search: 'location', nowSeconds: NOW }).length, 2);
    });

    it('filters by deletedBy', () => {
        const byAlice = filterAndSortModels(sampleModels, { deletedBy: '10', nowSeconds: NOW });
        assert.deepEqual(byAlice.map((m) => m.name), ['Aldric Stormborn', 'Crystal Spire']);

        const byUnknown = filterAndSortModels(sampleModels, { deletedBy: 'unknown', nowSeconds: NOW });
        assert.deepEqual(byUnknown.map((m) => m.name), ['Old Tavern']);
    });

    it('filters by type', () => {
        const posts = filterAndSortModels(sampleModels, { type: 'post:0', nowSeconds: NOW });
        assert.deepEqual(posts.map((m) => m.name), ['Backstory']);

        const locations = filterAndSortModels(sampleModels, { type: 'entity:2', nowSeconds: NOW });
        assert.deepEqual(locations.map((m) => m.name), ['Crystal Spire', 'Old Tavern']);
    });

    it('filters by timeframe', () => {
        assert.deepEqual(
            filterAndSortModels(sampleModels, { timeframe: '24h', nowSeconds: NOW }).map((m) => m.name),
            ['Aldric Stormborn'],
        );
        assert.deepEqual(
            filterAndSortModels(sampleModels, { timeframe: '7d', nowSeconds: NOW }).map((m) => m.name),
            ['Aldric Stormborn', 'Backstory'],
        );
        assert.deepEqual(
            filterAndSortModels(sampleModels, { timeframe: '30d', nowSeconds: NOW }).map((m) => m.name),
            ['Aldric Stormborn', 'Backstory', 'Crystal Spire'],
        );
        assert.deepEqual(
            filterAndSortModels(sampleModels, { timeframe: 'expiring', nowSeconds: NOW }).map((m) => m.name),
            ['Crystal Spire', 'Old Tavern'],
        );

        const boundary = [
            { id: 10, type: 'entity', type_id: 1, type_name: 'Character', name: 'Seven Days', days_left: 7, deleted_at_timestamp: NOW },
            { id: 11, type: 'entity', type_id: 1, type_name: 'Character', name: 'Eight Days', days_left: 8, deleted_at_timestamp: NOW },
        ];
        assert.deepEqual(
            filterAndSortModels(boundary, { timeframe: 'expiring', nowSeconds: NOW }).map((m) => m.name),
            ['Seven Days'],
        );
    });

    it('combines filters and sorts without mutating the source array', () => {
        const originalOrder = sampleModels.map((m) => m.name);

        const combined = filterAndSortModels(sampleModels, {
            deletedBy: '10',
            timeframe: '30d',
            sort: 'name',
            nowSeconds: NOW,
        });
        assert.deepEqual(combined.map((m) => m.name), ['Aldric Stormborn', 'Crystal Spire']);

        const oldest = filterAndSortModels(sampleModels, { sort: 'oldest', nowSeconds: NOW });
        assert.deepEqual(oldest.map((m) => m.name), ['Old Tavern', 'Crystal Spire', 'Backstory', 'Aldric Stormborn']);

        const byType = filterAndSortModels(sampleModels, { sort: 'type', nowSeconds: NOW });
        assert.deepEqual(byType.map((m) => m.name), ['Backstory', 'Aldric Stormborn', 'Crystal Spire', 'Old Tavern']);

        assert.deepEqual(sampleModels.map((m) => m.name), originalOrder);
    });
});
