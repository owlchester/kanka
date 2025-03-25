<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;
use Illuminate\Support\Facades\Storage;

class CampaignExport extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'type' => [
                'key' => 'type',
                'label' => 'campaigns/export.type',
                'render' => function ($model) {
                    $key = 'entities';
                    /** @var \App\Models\CampaignExport $model */
                    if ($model->type == \App\Models\CampaignExport::TYPE_ASSETS) {
                        $key = 'assets';
                    }

                    return __('campaigns/export.type_' . $key);
                },
            ],
            'status' => [
                'key' => 'status',
                'label' => 'campaigns/plugins.fields.status',
                'render' => function ($model) {
                    $key = 'running';
                    /** @var \App\Models\CampaignExport $model */
                    if ($model->status == \App\Models\CampaignExport::STATUS_FAILED) {
                        $key = 'failed';
                    } elseif ($model->status == \App\Models\CampaignExport::STATUS_SCHEDULED) {
                        $key = 'scheduled';
                    } elseif ($model->status == \App\Models\CampaignExport::STATUS_FINISHED) {
                        $key = 'finished';
                    }

                    return __('campaigns/export.status.' . $key);
                },
            ],
            'created_by' => [
                'key' => 'user.name',
                'label' => 'campaigns.members.fields.name',
                'render' => function ($model) {
                    if (! $model->created_by) {
                        return '';
                    }
                    $html = '<a class="block break-all truncate" href="' . route('users.profile', [$model->user]) . '" target="_blank">' . $model->user->name . '</a>';

                    return $html;
                },
            ],
            'created_at' => [
                'key' => 'created_at',
                'label' => 'campaigns.invites.fields.created',
                'render' => function ($model) {
                    $html = '<span data-title="' . $model->created_at . 'UTC" data-toggle="tooltip">' . $model->created_at->diffForHumans() . '</span>';

                    return $html;
                },
            ],
            'progress' => [
                'label' => 'campaigns/export.progress',
                'render' => function ($model) {
                    if ($model->finished()) {
                        return '100%';
                    } elseif (! $model->running()) {
                        return '';
                    } elseif (empty($model->progress)) {
                        return '<i>' . __('Calculating') . '</i>';
                    }

                    return $model->progress . '%';
                },
            ],
            'size' => [
                'label' => 'campaigns/export.size',
                'render' => function ($model) {
                    if (! $model->finished()) {
                        return '';
                    }
                    if (empty($model->size)) {
                        return '<1 MB';
                    }

                    return number_format($model->size) . ' MB';
                },
            ],
            'download' => [
                'label' => 'campaigns/export.actions.download',
                'render' => function ($model) {
                    if (! $model->finished()) {
                        return '';
                    }
                    if ($model->path && Storage::exists($model->path)) {
                        $html = '<a class="block break-all truncate" href="' . Storage::url($model->path) . '" target="_blank">' . __('campaigns/export.actions.download') . '</a>';

                        return $html;
                    } elseif ($model->path) {
                        return '<span class="text-neutral-content">' . __('campaigns/export.expired') . '</span>';
                    }

                    return '';
                },
            ],
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     */
    public function actions(): array
    {
        return [
        ];
    }

    public function bulks(): array
    {
        return [
        ];
    }
}
