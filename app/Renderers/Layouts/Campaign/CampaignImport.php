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
            'user_id' => [
                'key' => 'user.name',
                'label' => 'campaigns.members.fields.name',
                'render' => function (\App\Models\CampaignImport $model) {
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
                'render' => function (\App\Models\CampaignImport $model) {
                    $html = '<span data-title="' . $model->updated_at . 'UTC" data-toggle="tooltip">' . $model->updated_at->diffForHumans() . '</span>';

                    return $html;
                },
            ],
            'status' => [
                'key' => 'status_id',
                'label' => 'campaigns/plugins.fields.status',
                'render' => function (\App\Models\CampaignImport $model) {
                    if ($model->status_id === CampaignImportStatus::FAILED) {
                        return '<span class="text-error"><i class="fa-regular fa-xmark-circle" aria-hidden="true"></i> ' .  __('campaigns/import.status.failed') . '</span>';
                    } elseif ($model->status_id == CampaignImportStatus::QUEUED) {
                        return '<span class="text-neutral-content"><i class="fa-regular fa-hourglass" aria-hidden="true"></i> ' .  __('campaigns/import.status.queued') . '</span>';
                    } elseif ($model->status_id == CampaignImportStatus::FINISHED) {
                        return '<span class="text-success"><i class="fa-regular fa-check-circle" aria-hidden="true"></i> ' .  __('campaigns/import.status.finished') . '</span>';
                    }
                    return '<span class="text-neutral-content"><i class="fa-regular fa-spinner fa-spin" aria-hidden="true"></i> ' .  __('campaigns/import.status.running') . '</span>';
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
