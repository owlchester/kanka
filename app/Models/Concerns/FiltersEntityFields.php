<?php

namespace App\Models\Concerns;

use App\Enums\AttributeType;
use App\Enums\EntityAssetType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait FiltersEntityFields
{
    protected function applyEntityImageFilter(Builder $query, string $entityTable, mixed $value): void
    {
        $query->where(function (Builder $query) use ($entityTable, $value): void {
            if ($value) {
                $query->whereNotNull($entityTable . '.image_uuid')
                    ->orWhereNotNull($entityTable . '.image_path');
            } else {
                $query->whereNull($entityTable . '.image_uuid')
                    ->whereNull($entityTable . '.image_path');
            }
        });
    }

    protected function applyEntityTemplateFilter(Builder $query, string $entityTable, mixed $value): void
    {
        if ($value) {
            $query->where($entityTable . '.is_template', true);

            return;
        }

        $query->where(function (Builder $query) use ($entityTable): void {
            $query->whereNull($entityTable . '.is_template')
                ->orWhere($entityTable . '.is_template', false);
        });
    }

    protected function applyEntityArchivedFilter(Builder $query, string $entityTable, mixed $value): void
    {
        if ($value) {
            $query->whereNotNull($entityTable . '.archived_at');
        }
    }

    protected function applyEntityEntryFilter(Builder $query, string $entityTable, mixed $value): void
    {
        if ($value) {
            $query->whereNotNull($entityTable . '.entry')
                ->where($entityTable . '.entry', '!=', '');

            return;
        }

        $query->where(function (Builder $query) use ($entityTable): void {
            $query->whereNull($entityTable . '.entry')
                ->orWhere($entityTable . '.entry', '');
        });
    }

    protected function applyEntityFilesFilter(Builder $query, string $entityTable, mixed $value): void
    {
        $this->applyEntityRelationPresenceFilter(
            $query,
            $entityTable,
            'entity_assets',
            'entity_id',
            $value,
            fn ($query) => $query->where('entity_assets.type_id', EntityAssetType::file->value),
        );
    }

    protected function applyEntityPostsFilter(Builder $query, string $entityTable, mixed $value): void
    {
        $this->applyEntityRelationPresenceFilter($query, $entityTable, 'posts', 'entity_id', $value);
    }

    protected function applyEntityAttributesPresenceFilter(Builder $query, string $entityTable, mixed $value): void
    {
        $this->applyEntityRelationPresenceFilter($query, $entityTable, 'attributes', 'entity_id', $value);
    }

    protected function applyEntityAttributeFilter(
        Builder $query,
        string $entityTable,
        ?string $name,
        ?string $attributeValue,
    ): void {
        if ($name === null || $name === '') {
            return;
        }

        [$operator, $filterName] = $this->entitySearchOperator($name, 'attribute_name');
        if ($operator === 'not like') {
            $query->whereNotExists(function ($subquery) use ($entityTable, $filterName): void {
                $subquery->selectRaw('1')
                    ->from('attributes as entity_filter_attributes')
                    ->whereColumn('entity_filter_attributes.entity_id', $entityTable . '.id')
                    ->where('entity_filter_attributes.name', $filterName);
            });

            return;
        }

        $query->whereExists(function ($subquery) use ($entityTable, $filterName, $attributeValue): void {
            $subquery->selectRaw('1')
                ->from('attributes as entity_filter_attributes')
                ->whereColumn('entity_filter_attributes.entity_id', $entityTable . '.id')
                ->where('entity_filter_attributes.name', $filterName);

            if ($attributeValue === '!') {
                $subquery->where('entity_filter_attributes.value', '<>', '');
            } elseif ($attributeValue !== null && Str::startsWith($attributeValue, '!')) {
                $subquery->where(function ($query) use ($attributeValue): void {
                    $query->where('entity_filter_attributes.value', 'not like', '%' . mb_ltrim($attributeValue, '!') . '%')
                        ->orWhereNull('entity_filter_attributes.value');
                });
            } elseif ($attributeValue === '0') {
                $subquery->where(function ($query): void {
                    $query->where('entity_filter_attributes.value', '0')
                        ->orWhere(function ($query): void {
                            $query->where('entity_filter_attributes.type_id', AttributeType::Checkbox->value)
                                ->whereNull('entity_filter_attributes.value');
                        });
                });
            } elseif ($attributeValue !== '' && $attributeValue !== null) {
                $subquery->where('entity_filter_attributes.value', $attributeValue);
            }
        });
    }

    protected function applyEntityConnectionsFilter(
        Builder $query,
        string $entityTable,
        mixed $targetId,
        ?string $connectionName,
    ): void {
        $query->whereExists(function ($subquery) use ($entityTable, $targetId, $connectionName): void {
            $subquery->selectRaw('1')
                ->from('relations as entity_filter_relations')
                ->whereColumn('entity_filter_relations.owner_id', $entityTable . '.id');

            if ($targetId !== '' && $targetId !== null) {
                $subquery->where('entity_filter_relations.target_id', $targetId);
            }

            if ($connectionName !== '' && $connectionName !== null) {
                [$operator, $filterName] = $this->entitySearchOperator($connectionName, 'connection_name');
                if ($operator === 'IS NULL') {
                    $subquery->whereNull('entity_filter_relations.relation');

                    return;
                }
                $subquery->where(
                    'entity_filter_relations.relation',
                    $operator,
                    $operator === '=' ? $filterName : '%' . $filterName . '%',
                );
            }
        });
    }

    protected function applyEntityTagsFilter(
        Builder $query,
        string $entityTable,
        null|string|array $tags,
        ?string $option,
    ): void {
        $tagIds = collect((array) $tags)
            ->filter(fn ($tag) => is_numeric($tag))
            ->map(fn ($tag) => (int) $tag)
            ->unique()
            ->values()
            ->all();

        if ($option === 'none') {
            $this->applyEntityRelationPresenceFilter($query, $entityTable, 'entity_tags', 'entity_id', false);

            return;
        }

        if (empty($tagIds)) {
            return;
        }

        if ($option === 'exclude') {
            $query->whereNotExists(function ($subquery) use ($entityTable, $tagIds): void {
                $subquery->selectRaw('1')
                    ->from('entity_tags as entity_filter_tags')
                    ->whereColumn('entity_filter_tags.entity_id', $entityTable . '.id')
                    ->whereIn('entity_filter_tags.tag_id', $tagIds);
            });

            return;
        }

        if ($option === 'any') {
            $query->whereExists(function ($subquery) use ($entityTable, $tagIds): void {
                $subquery->selectRaw('1')
                    ->from('entity_tags as entity_filter_tags')
                    ->whereColumn('entity_filter_tags.entity_id', $entityTable . '.id')
                    ->whereIn('entity_filter_tags.tag_id', $tagIds);
            });

            return;
        }

        foreach ($tagIds as $tagId) {
            $query->whereExists(function ($subquery) use ($entityTable, $tagId): void {
                $subquery->selectRaw('1')
                    ->from('entity_tags as entity_filter_tags')
                    ->whereColumn('entity_filter_tags.entity_id', $entityTable . '.id')
                    ->where('entity_filter_tags.tag_id', $tagId);
            });
        }
    }

    protected function entitySearchOperator(string $value, string $key): array
    {
        if ($value === '!!') {
            return ['IS NULL', null];
        }
        if (Str::startsWith($value, '!')) {
            return ['not like', mb_ltrim($value, '!')];
        }
        if (Str::endsWith($value, '!')) {
            return ['=', mb_rtrim($value, '!')];
        }
        if (Str::endsWith($key, '_id')) {
            return ['=', $value];
        }

        return ['like', $value];
    }

    protected function applyEntityRelationPresenceFilter(
        Builder $query,
        string $entityTable,
        string $relationTable,
        string $foreignKey,
        mixed $value,
        ?callable $constraint = null,
    ): void {
        $callback = function ($subquery) use ($entityTable, $relationTable, $foreignKey, $constraint): void {
            $subquery->selectRaw('1')
                ->from($relationTable)
                ->whereColumn($relationTable . '.' . $foreignKey, $entityTable . '.id');

            if ($constraint) {
                $constraint($subquery);
            }
        };

        if ($value) {
            $query->whereExists($callback);
        } else {
            $query->whereNotExists($callback);
        }
    }
}
