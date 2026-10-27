<?php

namespace App\Renderers\Layouts\Entity;

use App\Models\Entity;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;
use App\Traits\EntityTypeAware;

class Children extends Layout
{
    use EntityTypeAware;

    protected array $optionalColumns = [];

    public function optionalColumns(array $columns): self
    {
        $this->optionalColumns = $columns;

        return $this;
    }

    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE,
            ],
            'race_id' => [
                'key' => 'name',
                'label' => $this->entityType->name(),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
            ],
            'parent' => [
                'key' => 'parent.name',
                'label' => __('crud.fields.parent'),
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return request()->get('m') != 0;
                },
            ],
            'children' => [
                'label' => __('tags.fields.children'),
                'render' => function ($model) {
                    return $model->children->count();
                },
            ],
        ];

        $statusColumn = null;
        foreach ($this->optionalColumns as $column) {
            if ($column['key'] === 'status') {
                $statusColumn = [
                    'key' => $column['sortKey'],
                    'label' => __('entities.status'),
                    'render' => function (Entity $model) {
                        if (! $model->status) {
                            return '';
                        }
                        $model->status->setRelation('entityType', $model->entityType);

                        return $model->status->icon
                            ? '<i class="' . $model->status->icon() . '" data-title="' . e($model->status->name()) . '" aria-hidden="true"></i>'
                            : e($model->status->name());
                    },
                ];
            } elseif ($column['key'] === 'calendar_date') {
                $columns['calendar_date'] = [
                    'key' => $column['sortKey'],
                    'label' => __('crud.fields.calendar_date'),
                    'render' => fn (Entity $model) => $model->calendarReminder()?->readableDate() ?? '',
                ];
            } elseif ($column['key'] === 'locations') {
                $columns['locations'] = [
                    'label' => __('entities.locations'),
                    'render' => function (Entity $model) {
                        return $model->locations
                            ->map(fn ($location) => $this->entityLink($location->entity))->implode(', ');
                    },
                ];
            }
        }

        if ($statusColumn !== null) {
            $columns['status'] = $statusColumn;
        }
        $columns['tags'] = [
            'render' => Standard::TAGS,
        ];

        return $columns;
    }
}
