<?php

namespace App\Http\Resources;

use App\Models\Conversation;

class ConversationResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var Conversation $model */
        $model = $this->resource;

        return $this->entity([
            'target' => $model->forEntities() ? 'characters' : 'members',
            'target_type' => $model->forEntities() ? 'entities' : 'members',
            'target_id' => $model->target_id,
            'is_closed' => $model->is_closed,
            'participants' => $model->participants()->count(),
            'messages' => $model->messages()->count(),
        ]);
    }
}
