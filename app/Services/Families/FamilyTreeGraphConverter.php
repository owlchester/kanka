<?php

namespace App\Services\Families;

use Illuminate\Support\Str;

class FamilyTreeGraphConverter
{
    /**
     * Convert the legacy recursive tree into the flat graph used by the prototype.
     */
    public function convert(array $config): array
    {
        if ($this->isFlat($config)) {
            return $this->normaliseFlat($config);
        }

        $graph = [
            'nodes' => [],
            'edges' => [],
        ];

        foreach ($config as $node) {
            if (is_array($node)) {
                $this->convertLegacyNode($node, $graph);
            }
        }

        return $graph;
    }

    public function isFlat(array $config): bool
    {
        return array_key_exists('nodes', $config) || array_key_exists('edges', $config);
    }

    protected function convertLegacyNode(array $legacyNode, array &$graph): string
    {
        $nodeId = $this->uniqueId($legacyNode['uuid'] ?? null, $graph['nodes']);
        $graph['nodes'][] = $this->node($nodeId, $legacyNode);

        foreach ($legacyNode['relations'] ?? [] as $relation) {
            if (! is_array($relation)) {
                continue;
            }

            $relationId = $this->convertLegacyNode($relation, $graph);
            $graph['edges'][] = $this->edge($nodeId, $relationId, ['edge_id' => null] + $relation, 'partner', $graph['edges']);

            foreach ($relation['children'] ?? [] as $child) {
                if (! is_array($child)) {
                    continue;
                }

                $childId = $this->convertLegacyNode($child, $graph);
                $graph['edges'][] = $this->edge($nodeId, $childId, ['edge_id' => null] + $child, 'parent', $graph['edges']);
                $graph['edges'][] = $this->edge($relationId, $childId, ['edge_id' => null] + $child, 'parent', $graph['edges']);
            }
        }

        return $nodeId;
    }

    protected function normaliseFlat(array $config): array
    {
        $nodes = [];
        $idMap = [];

        foreach ($config['nodes'] ?? [] as $node) {
            if (! is_array($node)) {
                continue;
            }

            $oldId = $node['id'] ?? $node['uuid'] ?? null;
            $newId = $this->uniqueId($oldId, $nodes);
            if (is_string($oldId) && ! isset($idMap[$oldId])) {
                $idMap[$oldId] = $newId;
            }
            $nodes[] = $this->node($newId, $node);
        }

        $nodeIds = array_column($nodes, 'id');
        $edges = [];
        foreach ($config['edges'] ?? [] as $edge) {
            if (! is_array($edge)) {
                continue;
            }

            $source = $idMap[$edge['source'] ?? ''] ?? $edge['source'] ?? null;
            $target = $idMap[$edge['target'] ?? ''] ?? $edge['target'] ?? null;
            if (! is_string($source) || ! is_string($target) || ! in_array($source, $nodeIds, true) || ! in_array($target, $nodeIds, true)) {
                continue;
            }

            $type = in_array($edge['type'] ?? null, ['partner', 'parent'], true) ? $edge['type'] : 'partner';
            $edges[] = $this->edge($source, $target, $edge, $type, $edges);
        }

        return [
            'nodes' => $nodes,
            'edges' => $edges,
        ];
    }

    protected function node(string $id, array $data): array
    {
        return [
            'id' => $id,
            'entity_id' => isset($data['entity_id']) && $data['entity_id'] !== '' ? (int) $data['entity_id'] : null,
            'isUnknown' => (bool) ($data['isUnknown'] ?? false),
            'role' => (string) ($data['role'] ?? ''),
            'colour' => (string) ($data['colour'] ?? ''),
            'cssClass' => (string) ($data['cssClass'] ?? ''),
            'visibility' => (int) ($data['visibility'] ?? 1),
        ];
    }

    protected function edge(string $source, string $target, array $data, string $type, array $edges = []): array
    {
        $edgeId = array_key_exists('edge_id', $data)
            ? $data['edge_id']
            : ($data['id'] ?? $data['uuid'] ?? null);

        return [
            'id' => $this->uniqueId($edgeId, $edges),
            'source' => $source,
            'target' => $target,
            'type' => $type,
            'role' => (string) ($data['role'] ?? ''),
            'parentage' => (string) ($data['parentage'] ?? ''),
            'colour' => (string) ($data['colour'] ?? ''),
            'cssClass' => (string) ($data['cssClass'] ?? ''),
            'visibility' => (int) ($data['visibility'] ?? 1),
        ];
    }

    protected function uniqueId(mixed $candidate, array $elements): string
    {
        $used = array_column($elements, 'id');
        if (is_string($candidate) && Str::isUuid($candidate) && ! in_array($candidate, $used, true)) {
            return $candidate;
        }

        do {
            $id = (string) Str::uuid();
        } while (in_array($id, $used, true));

        return $id;
    }
}
