<?php

namespace App\Services\Families;

use App\Enums\FamilyTreeChildType;
use App\Enums\FamilyTreePartnerStatus;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FamilyTreeGraph
{
    public const VERSION = 2;

    /**
     * Turn either the current nested format or the graph format into a graph.
     */
    public static function normalize(?array $data): array
    {
        if (empty($data)) {
            return self::empty();
        }

        if (isset($data['nodes'], $data['edges'])) {
            return self::prepare($data);
        }

        return self::fromLegacy($data);
    }

    public static function empty(): array
    {
        return [
            'version' => self::VERSION,
            'nodes' => [],
            'edges' => [],
        ];
    }

    /**
     * Convert the old relation/children tree while preserving every visible
     * occurrence of a character as a separate graph node.
     */
    public static function fromLegacy(array $legacy): array
    {
        $graph = self::empty();

        foreach ($legacy as $node) {
            if (is_array($node)) {
                self::addLegacyNode($node, $graph);
            }
        }

        return self::prepare($graph);
    }

    public static function validate(array $graph): void
    {
        $nodeIds = [];
        foreach ($graph['nodes'] ?? [] as $node) {
            if (! is_array($node) || empty($node['id']) || isset($nodeIds[$node['id']])) {
                throw ValidationException::withMessages(['data' => 'Every family tree node needs a unique id.']);
            }
            if (($node['entity_id'] ?? null) === null && ! ($node['isUnknown'] ?? false)) {
                throw ValidationException::withMessages(['data' => 'Nodes without a character must be marked unknown.']);
            }
            $nodeIds[$node['id']] = true;
        }

        $edgeIds = [];
        $children = [];
        foreach ($graph['edges'] ?? [] as $edge) {
            if (! is_array($edge) || empty($edge['id']) || isset($edgeIds[$edge['id']])) {
                throw ValidationException::withMessages(['data' => 'Family tree edge ids must be unique.']);
            }
            if (! isset($nodeIds[$edge['source']], $nodeIds[$edge['target']])) {
                throw ValidationException::withMessages(['data' => 'Family tree edges must reference existing nodes.']);
            }
            if ($edge['source'] === $edge['target']) {
                throw ValidationException::withMessages(['data' => 'Family tree edges cannot connect a node to itself.']);
            }
            if (! in_array($edge['type'] ?? null, ['partner', 'child'], true)) {
                throw ValidationException::withMessages(['data' => 'Family tree edges have an invalid type.']);
            }
            if ($edge['type'] === 'child') {
                $childType = (int) ($edge['child_type'] ?? FamilyTreeChildType::Biological->value);
                if (! in_array($childType, FamilyTreeChildType::values(), true)) {
                    throw ValidationException::withMessages(['data' => 'Family tree child types are invalid.']);
                }
                if ($childType === FamilyTreeChildType::Custom->value && trim((string) ($edge['role'] ?? '')) === '') {
                    throw ValidationException::withMessages(['data' => 'Custom child relationships need a role.']);
                }
                if (mb_strlen((string) ($edge['role'] ?? '')) > 70) {
                    throw ValidationException::withMessages(['data' => 'Family tree roles cannot be longer than 70 characters.']);
                }
                $children[$edge['source']][] = $edge['target'];
            } elseif (! in_array($edge['partner_status'] ?? FamilyTreePartnerStatus::Current->value, FamilyTreePartnerStatus::values(), true)) {
                throw ValidationException::withMessages(['data' => 'Family tree partner statuses are invalid.']);
            }
            $edgeIds[$edge['id']] = true;
        }

        if (self::hasCycle($children)) {
            throw ValidationException::withMessages(['data' => 'Family tree child relationships cannot contain a cycle.']);
        }
    }

    /**
     * Assign proper UUIDs while keeping edge references intact.
     */
    public static function prepare(array $data): array
    {
        $graph = [
            'version' => self::VERSION,
            'nodes' => array_values($data['nodes'] ?? []),
            'edges' => array_values($data['edges'] ?? []),
        ];
        $nodeIds = [];

        foreach ($graph['nodes'] as &$node) {
            if (! is_array($node)) {
                $node = [];
            }
            $oldId = (string) ($node['id'] ?? '');
            $newId = Str::isUuid($oldId) ? $oldId : (string) Str::uuid();
            $nodeIds[$oldId] = $newId;
            $node['id'] = $newId;
            $node['entity_id'] = isset($node['entity_id']) && $node['entity_id'] !== '' ? (int) $node['entity_id'] : null;
            $node['isUnknown'] = (bool) ($node['isUnknown'] ?? false);
            $node['cssClass'] = (string) ($node['cssClass'] ?? '');
            $node['colour'] = (string) ($node['colour'] ?? '');
            $node['visibility'] = (int) ($node['visibility'] ?? 1);
        }
        unset($node);

        foreach ($graph['edges'] as &$edge) {
            if (! is_array($edge)) {
                $edge = [];
            }
            $edge['id'] = Str::isUuid((string) ($edge['id'] ?? '')) ? $edge['id'] : (string) Str::uuid();
            $edge['source'] = $nodeIds[(string) ($edge['source'] ?? '')] ?? $edge['source'] ?? '';
            $edge['target'] = $nodeIds[(string) ($edge['target'] ?? '')] ?? $edge['target'] ?? '';
            $edge['type'] = ($edge['type'] ?? 'partner') === 'child' ? 'child' : 'partner';
            $edge['role'] = isset($edge['role']) ? trim((string) $edge['role']) : null;
            $edge['cssClass'] = (string) ($edge['cssClass'] ?? '');
            $edge['colour'] = (string) ($edge['colour'] ?? '');
            $edge['visibility'] = (int) ($edge['visibility'] ?? 1);
            if ($edge['type'] === 'child') {
                $edge['child_type'] = (int) ($edge['child_type'] ?? FamilyTreeChildType::Biological->value);
                unset($edge['partner_status']);
            } else {
                $edge['partner_status'] = $edge['partner_status'] ?? FamilyTreePartnerStatus::Current->value;
                unset($edge['child_type']);
            }
        }
        unset($edge);

        return $graph;
    }

    protected static function addLegacyNode(array $legacy, array &$graph): string
    {
        $nodeId = (string) Str::uuid();
        $graph['nodes'][] = [
            'id' => $nodeId,
            'entity_id' => $legacy['entity_id'] ?? null,
            'isUnknown' => (bool) ($legacy['isUnknown'] ?? false),
            'cssClass' => $legacy['cssClass'] ?? '',
            'colour' => $legacy['colour'] ?? '',
            'visibility' => $legacy['visibility'] ?? 1,
        ];

        foreach ($legacy['relations'] ?? [] as $relation) {
            if (! is_array($relation)) {
                continue;
            }
            $partnerId = self::addLegacyNode($relation, $graph);
            $graph['edges'][] = self::legacyEdge($nodeId, $partnerId, $relation, 'partner');

            foreach ($relation['children'] ?? [] as $child) {
                if (! is_array($child)) {
                    continue;
                }
                $childId = self::addLegacyNode($child, $graph);
                $childEdge = self::legacyEdge($nodeId, $childId, $child, 'child');
                $childEdge['child_type'] = empty($child['role'])
                    ? FamilyTreeChildType::Biological->value
                    : FamilyTreeChildType::Custom->value;
                $graph['edges'][] = $childEdge;
                $secondParentEdge = self::legacyEdge($partnerId, $childId, $child, 'child');
                $secondParentEdge['child_type'] = $childEdge['child_type'];
                $graph['edges'][] = $secondParentEdge;
            }
        }

        return $nodeId;
    }

    protected static function legacyEdge(string $source, string $target, array $data, string $type): array
    {
        return [
            'id' => (string) Str::uuid(),
            'source' => $source,
            'target' => $target,
            'type' => $type,
            'role' => $data['role'] ?? null,
            'cssClass' => $data['cssClass'] ?? '',
            'colour' => $data['colour'] ?? '',
            'visibility' => $data['visibility'] ?? 1,
            'partner_status' => FamilyTreePartnerStatus::Current->value,
        ];
    }

    protected static function hasCycle(array $children): bool
    {
        $visited = [];
        $active = [];
        foreach (array_keys($children) as $node) {
            if (self::visit($node, $children, $visited, $active)) {
                return true;
            }
        }

        return false;
    }

    protected static function visit(string $node, array $children, array &$visited, array &$active): bool
    {
        if (($active[$node] ?? false) === true) {
            return true;
        }
        if (($visited[$node] ?? false) === true) {
            return false;
        }
        $visited[$node] = true;
        $active[$node] = true;
        foreach ($children[$node] ?? [] as $child) {
            if (self::visit($child, $children, $visited, $active)) {
                return true;
            }
        }
        $active[$node] = false;

        return false;
    }
}
