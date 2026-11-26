<?php

use App\Enums\Visibility;
use App\Services\Families\FamilyTreeMigrator;

it('returns an empty v2 graph for null or empty config', function () {
    $expected = [
        'version' => 2,
        'settings' => [
            'direction' => 'TB',
            'edgeStyle' => 'orthogonal',
            'compact' => false,
        ],
        'people' => [],
        'unions' => [],
        'links' => [],
    ];

    expect(FamilyTreeMigrator::toV2(null))->toBe($expected)
        ->and(FamilyTreeMigrator::toV2([]))->toBe($expected);
});

it('migrates a legacy nested v1 tree with spouses and children losslessly', function () {
    $legacy = [
        [
            'uuid' => 'node-founder',
            'entity_id' => 10,
            'colour' => '#ff0000',
            'cssClass' => 'royal-founder',
            'visibility' => Visibility::All->value,
            'relations' => [
                [
                    'uuid' => 'rel-spouse-1',
                    'entity_id' => 11,
                    'role' => 'Queen Consort',
                    'colour' => '#00ff00',
                    'cssClass' => 'consort',
                    'visibility' => Visibility::Member->value,
                    'children' => [
                        [
                            'uuid' => 'node-child-1',
                            'entity_id' => 12,
                            'visibility' => Visibility::Admin->value,
                        ],
                    ],
                ],
            ],
        ],
    ];

    $v2 = FamilyTreeMigrator::toV2($legacy);

    expect($v2['version'])->toBe(2)
        ->and($v2['people'])->toHaveCount(3)
        ->and($v2['unions'])->toHaveCount(1)
        ->and($v2['links'])->toHaveCount(1);

    $founder = $v2['people'][0];
    expect($founder['id'])->toBe('node-founder')
        ->and($founder['entity_id'])->toBe(10)
        ->and($founder['colour'])->toBe('#ff0000')
        ->and($founder['cssClass'])->toBe('royal-founder')
        ->and($founder['visibility'])->toBe(Visibility::All->value);

    $spouse = $v2['people'][1];
    expect($spouse['entity_id'])->toBe(11)
        ->and($spouse['visibility'])->toBe(Visibility::Member->value);

    $union = $v2['unions'][0];
    expect($union['id'])->toBe('rel-spouse-1')
        ->and($union['partners'])->toBe(['node-founder', $spouse['id']])
        ->and($union['type'])->toBe('married')
        ->and($union['role'])->toBe('Queen Consort')
        ->and($union['colour'])->toBe('#00ff00')
        ->and($union['cssClass'])->toBe('consort')
        ->and($union['visibility'])->toBe(Visibility::Member->value);

    $link = $v2['links'][0];
    expect($link['union_id'])->toBe('rel-spouse-1')
        ->and($link['parent_id'])->toBeNull()
        ->and($link['child_id'])->toBe('node-child-1')
        ->and($link['kind'])->toBe('biological')
        ->and($link['visibility'])->toBe(Visibility::Admin->value);
});

it('converts a pure legacy unknown spouse wrapper into a direct single-parent link', function () {
    $legacy = [
        [
            'uuid' => 'node-bob',
            'entity_id' => 20,
            'relations' => [
                [
                    'uuid' => 'rel-unknown',
                    'entity_id' => '',
                    'isUnknown' => true,
                    'children' => [
                        [
                            'uuid' => 'node-linda',
                            'entity_id' => 21,
                        ],
                    ],
                ],
            ],
        ],
    ];

    $v2 = FamilyTreeMigrator::toV2($legacy);

    expect($v2['people'])->toHaveCount(2)
        ->and($v2['unions'])->toHaveCount(0)
        ->and($v2['links'])->toHaveCount(1);

    expect($v2['links'][0]['union_id'])->toBeNull()
        ->and($v2['links'][0]['parent_id'])->toBe('node-bob')
        ->and($v2['links'][0]['child_id'])->toBe('node-linda')
        ->and($v2['links'][0]['kind'])->toBe('biological');
});

it('preserves a styled legacy unknown spouse as a placeholder partner and union', function () {
    $legacy = [
        [
            'uuid' => 'node-bob',
            'entity_id' => 20,
            'relations' => [
                [
                    'uuid' => 'rel-mystery',
                    'entity_id' => '',
                    'isUnknown' => true,
                    'role' => 'Secret Lover',
                    'colour' => '#999999',
                    'children' => [
                        [
                            'uuid' => 'node-linda',
                            'entity_id' => 21,
                        ],
                    ],
                ],
            ],
        ],
    ];

    $v2 = FamilyTreeMigrator::toV2($legacy);

    expect($v2['people'])->toHaveCount(3)
        ->and($v2['unions'])->toHaveCount(1)
        ->and($v2['links'])->toHaveCount(1);

    $mysteryPartner = $v2['people'][1];
    expect($mysteryPartner['entity_id'])->toBeNull()
        ->and($mysteryPartner['placeholder'])->toBe(['name' => '', 'subtitle' => '']);

    expect($v2['unions'][0]['role'])->toBe('Secret Lover')
        ->and($v2['unions'][0]['colour'])->toBe('#999999')
        ->and($v2['links'][0]['union_id'])->toBe('rel-mystery');
});

it('is idempotent for already-v2 configs', function () {
    $v2 = [
        'version' => 2,
        'settings' => [
            'direction' => 'LR',
            'edgeStyle' => 'bezier',
            'compact' => true,
        ],
        'people' => [
            [
                'id' => 'p-1',
                'entity_id' => null,
                'placeholder' => ['name' => 'Great Uncle Jim', 'subtitle' => 'BBEG'],
                'colour' => null,
                'cssClass' => null,
                'visibility' => 1,
            ],
        ],
        'unions' => [],
        'links' => [],
    ];

    expect(FamilyTreeMigrator::toV2($v2))->toBe($v2);
});

it('extracts unique positive entity ids from both v1 and v2 configs', function () {
    $v1 = [
        [
            'uuid' => '1',
            'entity_id' => '5',
            'relations' => [
                ['uuid' => '2', 'entity_id' => 6, 'children' => [['uuid' => '3', 'entity_id' => 5]]],
                ['uuid' => '4', 'entity_id' => '', 'isUnknown' => true],
            ],
        ],
    ];

    $v2 = [
        'version' => 2,
        'people' => [
            ['id' => 'p1', 'entity_id' => 10],
            ['id' => 'p2', 'entity_id' => null],
            ['id' => 'p3', 'entity_id' => 10],
            ['id' => 'p4', 'entity_id' => 12],
        ],
    ];

    expect(FamilyTreeMigrator::extractEntityIds($v1))->toBe([5, 6])
        ->and(FamilyTreeMigrator::extractEntityIds($v2))->toBe([10, 12]);
});
