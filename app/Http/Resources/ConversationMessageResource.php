<?php

namespace App\Http\Resources;

use App\Models\ConversationMessage;

class ConversationMessageResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ConversationMessage $resource */
        $resource = $this->resource;

        return [
            'conversation_id' => $resource->conversation_id,
            'created_by' => $resource->created_by,
            'character_id' => $resource->character_id,
            'user_id' => $resource->user_id,
            'message' => $resource->message,
        ];
    }
}
