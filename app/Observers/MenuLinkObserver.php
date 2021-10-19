<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\MenuLink;
use App\Models\MiscModel;
use App\Models\Tag;

class MenuLinkObserver
{
    use PurifiableTrait;
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        if (!$model->savingObserver) {
            return;
        }

        $model->campaign_id = CampaignLocalization::getCampaign()->id;
        //$model->icon = $this->purify($model->icon);
        $model->tab = strtolower(trim($model->tab, '#'));

        // Handle empty or wrong positions
        if (empty($model->position)) {
            $model->position = MenuLink::max('position') + 1;
        } else {
            $model->position = (int) $model->position;
        }

        // Handle the entity type or direct entity
        if (!empty($model->type)) {
            $model->entity_id = null;
            $model->tab = null;
            $model->menu = '';
        } else {
            $model->type = null;
            $model->filters = null;
        }

        // Only allow certain keys in the options array
        $options = $model->options;
        if (!empty($options)) {
            $model->options = array_intersect_key($model->options, array_flip($model->optionsAllowedKeys));
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }

    /**
     * @param MiscModel|MenuLink $menuLink
     */
    public function saved(MiscModel $menuLink)
    {
        $this->saveTags($menuLink);
    }

    protected function saveTags(MiscModel $model)
    {
        if (!request()->has('save_tags')) {
            return;
        }

        // Only save tags if we are in a form.
        $ids = request()->post('tags', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($model->tags as $tag) {
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

        // Detach the remaining
        if (!empty($existing)) {
            $model->tags()->detach(array_keys($existing));
        }
    }
}
