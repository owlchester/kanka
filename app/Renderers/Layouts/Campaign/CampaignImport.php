<?php

namespace App\Renderers\Layouts\Campaign;

use App\Enums\CampaignImportStatus;
use App\Renderers\Layouts\Layout;

class CampaignImport extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'status' => [
                'key' => 'status_id',
                'label' => 'campaigns/plugins.fields.status',
                'render' => function ($model) {
                    $key = 'running';
                    /** @var \App\Models\CampaignImport $model */
                    if ($model->status_id === CampaignImportStatus::FAILED) {
                        $key = 'failed';
                    } elseif ($model->status_id == CampaignImportStatus::QUEUED) {
                        $key = 'queued';
                    } elseif ($model->status_id == CampaignImportStatus::FINISHED) {
                        $key = 'finished';
                    }

                    return __('campaigns/import.status.' . $key);
                },
            ],
            'user_id' => [
                'key' => 'user.name',
                'label' => 'campaigns.members.fields.name',
                'render' => function ($model) {
                    if (! $model->user_id) {
                        return '';
                    }
                    $html = '<a class="block break-all truncate" href="' . route('users.profile', [$model->user]) . '" target="_blank">' . $model->user->name . '</a>';

                    return $html;
                },
            ],
            'updated_at' => [
                'key' => 'updated_at',
                'label' => 'campaigns/import.fields.updated',
                'render' => function ($model) {
                    $html = '<span data-title="' . $model->updated_at . 'UTC" data-toggle="tooltip">' . $model->updated_at->diffForHumans() . '</span>';

                    return $html;
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
