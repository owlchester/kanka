<?php

namespace App\Renderers\Layouts\Campaign;

use App\Facades\CampaignLocalization;
use App\Renderers\Layouts\Layout;
use Illuminate\Support\Facades\Storage;


class CampaignExport extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'created_by' => [
                'key' => 'user.name',
                'label' => 'campaigns.exports.created_by',
                'render' => function ($model) {
                    $html = '<a class="block break-all truncate" href="' . route('users.profile', [$model->user]) . '" target="_blank">' . $model->user->name . '</a>';
                    return $html;
                },
            ],
            'size' => [
                'label' => 'campaigns.exports.size',
                'render' => function ($model) {
                    if ($model->size == 0) {
                        return '<1 MB';
                    }
                    return $model->size . ' MB';
                }
            ],
            'type' => [
                'key' => 'type',
                'label' => 'campaigns.exports.type',
                'render' => function ($model) {
                    $key = 'entities';
                    /** @var \App\Models\CampaignExport $model */
                    if ($model->type == \App\Models\CampaignExport::TYPE_ASSETS) {
                        $key = 'assets';
                    }

                    return __('campaigns.exports.type_' . $key);
                },
            ],
            'status' => [
                'key' => 'status',
                'label' => 'campaigns.exports.status',
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

                    return __('campaigns.exports.status_' . $key);
                },
            ],

            'created_at' => [
                'key' => 'created_at',
                'label' => 'campaigns.exports.created',
                'render' => function ($model) {
                    $html = '';

                    if (!empty($model->created_at)) {
                        $html = '<span data-title="' . $model->created_at . 'UTC" data-toggle="tooltip">' . $model->created_at->diffForHumans() . '</span>';
                    }
                    return $html;
                },
            ],
            'download' => [
                'label' => 'campaigns.exports.download',
                'render' => function ($model) {
                    if ($model->path && Storage::exists($model->path)) {
                        $html = '<a class="block break-all truncate" href="' . Storage::url($model->path) . '" target="_blank">' . __('campaigns.exports.download') . '</a>';
                        return $html;
                    } elseif ($model->path) {
                        return __('campaigns.exports.expired');
                    }

                    return '';
                }
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
