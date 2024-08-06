<?php

namespace App\Http\Resources;

use App\Models\ConversationParticipant;

class ConversationParticipantResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ConversationParticipant $resource */
        $resource = $this->resource;

        return [
            'conversation_id' => $resource->conversation_id,
            'character_id' => $resource->character_id,
            'user_id' => $resource->user_id,
        ];
    }
}
