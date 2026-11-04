<?php

namespace App\Http\Resources;

use App\Models\ConversationMessage;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationMessageResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ConversationMessage $resource */
        $resource = $this->resource;

        return [
            'conversation_id' => $resource->conversation_id,
            'created_by' => $resource->created_by,
            'entity_id' => $resource->participant instanceof Entity ? $resource->participant_id : null,
            'character_id' => $resource->participant instanceof Entity && $resource->participant->type_id == config('entities.ids.character') ? $resource->participant->entity_id : null,
            'user_id' => $resource->participant instanceof User ? $resource->participant_id : null,
            'message' => $resource->message,
        ];
    }
}
