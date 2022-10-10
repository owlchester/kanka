<?php

namespace App\Http\Resources;

use App\Models\ConversationParticipant;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'created_by' => $resource->created_by,
            'character_id' => $resource->character_id,
            'user_id' => $resource->user_id,
        ];
    }
}
