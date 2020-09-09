<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Quest;

class QuestObserver extends MiscObserver
{
    /**
     * @param Quest $model
     */
    public function deleting(MiscModel $model)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         * @var Quest $sub
         */
        foreach ($model->quests as $sub) {
            $sub->quest_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $model->refresh();
    }

    public function created(MiscModel $model)
    {
        parent::created($model);

        // Copy eras from timeline
        if (request()->has('copy_elements') && request()->filled('copy_elements')) {
            $sourceId = request()->post('copy_source_id');

            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->typeId() == config('entities.ids.quest')) {

                foreach ($source->quest->characters as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->quest_id = $model->id;
                    $newSub->save();
                }
                foreach ($source->quest->locations as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->quest_id = $model->id;
                    $newSub->save();
                }
                foreach ($source->quest->organisations as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->quest_id = $model->id;
                    $newSub->save();
                }
                foreach ($source->quest->items as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->quest_id = $model->id;
                    $newSub->save();
                }
            }
        }
    }
}
