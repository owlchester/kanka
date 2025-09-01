<?php

namespace App\Observers;

use App\Jobs\BragiQuestElementFeedJob;
use App\Models\Embedding;
use App\Models\QuestElement;

class QuestElementObserver 
{
    public function saved(QuestElement $questElement)
    {
        if (auth()->user()->can('ask', $questElement->quest->campaign)) {
            BragiQuestElementFeedJob::dispatch($questElement);
        }
    }

    public function deleted(QuestElement $questElement)
    {
        //Delete Ask Bragi embedding
        $oldEmbed = Embedding::where('parent_type', QuestElement::class )->where('parent_id', $questElement->id)->first();
        if ($oldEmbed) {
            $oldEmbed->delete();
        }
    }
}
