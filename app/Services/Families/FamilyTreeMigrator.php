<?php

namespace App\Services\Families;

use App\Enums\Visibility;
use Illuminate\Support\Str;

class FamilyTreeMigrator
{
    public const VERSION = 2;

    /**
     * @return array<string, mixed>
     */
    public static function empty(): array
    {
        return [
            'version' => self::VERSION,
            'settings' => [
                'direction' => 'TB',
                'edgeStyle' => 'orthogonal',
                'compact' => false,
            ],
            'people' => [],
            'unions' => [],
            'links' => [],
        ];
    }

    /**
     * @param  array<string, mixed>|null  $config
     */
    public static function isV2(?array $config): bool
    {
        return is_array($config)
            && isset($config['version'])
            && (int) $config['version'] === self::VERSION;
    }

    /**
     * Convert any legacy v1 nested tree config (or partial v2 config) into a normalized v2 graph.
     *
     * @param  array<string, mixed>|null  $config
     * @return array<string, mixed>
     */
    public static function toV2(?array $config): array
    {
        if (empty($config)) {
            return self::empty();
        }

        if (self::isV2($config)) {
            return [
                'version' => self::VERSION,
                'settings' => array_merge(self::empty()['settings'], is_array($config['settings'] ?? null) ? $config['settings'] : []),
                'people' => array_values(is_array($config['people'] ?? null) ? $config['people'] : []),
                'unions' => array_values(is_array($config['unions'] ?? null) ? $config['unions'] : []),
                'links' => array_values(is_array($config['links'] ?? null) ? $config['links'] : []),
            ];
        }

        $graph = self::empty();
        $seenIds = [];

        $nextId = function (?string $preferred = null) use (&$seenIds): string {
            if (is_string($preferred) && $preferred !== '' && ! isset($seenIds[$preferred])) {
                $seenIds[$preferred] = true;

                return $preferred;
            }
            do {
                $id = (string) Str::uuid();
            } while (isset($seenIds[$id]));
            $seenIds[$id] = true;

            return $id;
        };

        $walkNode = function (array $node) use (&$walkNode, &$graph, $nextId): ?string {
            $personId = $nextId(isset($node['uuid']) ? (string) $node['uuid'] : null);
            $entityId = self::normalizeEntityId($node['entity_id'] ?? null);
            $isUnknown = ! empty($node['isUnknown']) || $entityId === null;

            $graph['people'][] = [
                'id' => $personId,
                'entity_id' => $isUnknown ? null : $entityId,
                'placeholder' => $isUnknown ? ['name' => '', 'subtitle' => ''] : null,
                'colour' => self::nullableString($node['colour'] ?? null),
                'cssClass' => self::nullableString($node['cssClass'] ?? null),
                'visibility' => self::normalizeVisibility($node['visibility'] ?? null),
            ];

            $relations = is_array($node['relations'] ?? null) ? $node['relations'] : [];
            foreach ($relations as $order => $rel) {
                if (! is_array($rel)) {
                    continue;
                }

                $relEntityId = self::normalizeEntityId($rel['entity_id'] ?? null);
                $relUnknown = ! empty($rel['isUnknown']) || $relEntityId === null;
                $relRole = self::nullableString($rel['role'] ?? null);
                $relColour = self::nullableString($rel['colour'] ?? null);
                $relCssClass = self::nullableString($rel['cssClass'] ?? null);
                $relVisibility = self::normalizeVisibility($rel['visibility'] ?? null);
                $children = is_array($rel['children'] ?? null) ? $rel['children'] : [];

                $isPureUnknownWrapper = $relUnknown
                    && $relRole === null
                    && $relColour === null
                    && $relCssClass === null;

                if ($isPureUnknownWrapper && ! empty($children)) {
                    foreach ($children as $childOrder => $childNode) {
                        if (! is_array($childNode)) {
                            continue;
                        }
                        $childId = $walkNode($childNode);
                        if ($childId === null) {
                            continue;
                        }
                        $graph['links'][] = [
                            'id' => $nextId(),
                            'union_id' => null,
                            'parent_id' => $personId,
                            'child_id' => $childId,
                            'kind' => 'biological',
                            'label' => null,
                            'colour' => null,
                            'visibility' => self::normalizeVisibility($childNode['visibility'] ?? $rel['visibility'] ?? null),
                            'order' => (int) $childOrder,
                        ];
                    }

                    continue;
                }

                $partnerId = $nextId();
                $graph['people'][] = [
                    'id' => $partnerId,
                    'entity_id' => $relUnknown ? null : $relEntityId,
                    'placeholder' => $relUnknown ? ['name' => '', 'subtitle' => ''] : null,
                    'colour' => null,
                    'cssClass' => null,
                    'visibility' => $relVisibility,
                ];

                $unionId = $nextId(isset($rel['uuid']) ? (string) $rel['uuid'] : null);
                $graph['unions'][] = [
                    'id' => $unionId,
                    'partners' => [$personId, $partnerId],
                    'type' => 'married',
                    'role' => $relRole,
                    'colour' => $relColour,
                    'cssClass' => $relCssClass,
                    'visibility' => $relVisibility,
                    'order' => (int) $order,
                ];

                foreach ($children as $childOrder => $childNode) {
                    if (! is_array($childNode)) {
                        continue;
                    }
                    $childId = $walkNode($childNode);
                    if ($childId === null) {
                        continue;
                    }
                    $graph['links'][] = [
                        'id' => $nextId(),
                        'union_id' => $unionId,
                        'parent_id' => null,
                        'child_id' => $childId,
                        'kind' => 'biological',
                        'label' => null,
                        'colour' => null,
                        'visibility' => self::normalizeVisibility($childNode['visibility'] ?? $rel['visibility'] ?? null),
                        'order' => (int) $childOrder,
                    ];
                }
            }

            return $personId;
        };

        foreach ($config as $rootNode) {
            if (is_array($rootNode)) {
                $walkNode($rootNode);
            }
        }

        return $graph;
    }

    /**
     * Extract all unique positive integer entity_ids from either a v1 or v2 config.
     *
     * @param  array<string, mixed>|null  $config
     * @return int[]
     */
    public static function extractEntityIds(?array $config): array
    {
        if (empty($config)) {
            return [];
        }

        $ids = [];

        if (self::isV2($config)) {
            foreach ($config['people'] ?? [] as $person) {
                if (! is_array($person)) {
                    continue;
                }
                $id = self::normalizeEntityId($person['entity_id'] ?? null);
                if ($id !== null) {
                    $ids[$id] = $id;
                }
            }

            return array_values($ids);
        }

        array_walk_recursive($config, static function (mixed $value, string|int $key) use (&$ids): void {
            if ($key !== 'entity_id') {
                return;
            }
            $id = self::normalizeEntityId($value);
            if ($id !== null) {
                $ids[$id] = $id;
            }
        });

        return array_values($ids);
    }

    protected static function normalizeEntityId(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value > 0 ? $value : null;
        }
        if (is_string($value) && ctype_digit($value)) {
            $int = (int) $value;

            return $int > 0 ? $int : null;
        }

        return null;
    }

    protected static function normalizeVisibility(mixed $value): int
    {
        $int = is_numeric($value) ? (int) $value : Visibility::All->value;

        return in_array($int, [Visibility::All->value, Visibility::Admin->value, Visibility::Member->value], true)
            ? $int
            : Visibility::All->value;
    }

    protected static function nullableString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }
        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
