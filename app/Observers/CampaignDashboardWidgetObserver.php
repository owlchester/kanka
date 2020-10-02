<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignDashboardWidget;
use App\Models\Tag;

class CampaignDashboardWidgetObserver
{
    /**
     * @param CampaignDashboardWidget $model
     */
    public function saving(CampaignDashboardWidget $model)
    {
        $model->campaign_id = CampaignLocalization::getCampaign()->id;
    }

    /**
     * @param CampaignDashboardWidget $model
     */
    public function saved(CampaignDashboardWidget $model)
    {
        $this->saveTags($model);
    }

    /**
     * @param CampaignDashboardWidget $model
     */
    public function creating(CampaignDashboardWidget $model)
    {
        // Get position
        $model->position = 0;
        $last = CampaignDashboardWidget::with('entity')->orderBy('position', 'desc')->first();
        if (!empty($last)) {
            $model->position = $last->position + 1;
        }
    }

    /**
     * @param CampaignDashboardWidget $model
     */
    protected function saveTags(CampaignDashboardWidget $model)
    {
        if (!request()->has('save_tags')) {
            return;
        }

        // Only save tags if we are in a form.
        $ids = request()->post('tags', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($model->tags()->get() as $tag) {
            $existing[$tag->id] = $tag->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $tag = Tag::findOrFail($id);
                $new[] = $tag->id;
            }
        }
        $model->tags()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $model->tags()->detach(array_keys($existing));
        }
    }
}
