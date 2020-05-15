<?php

namespace App\Http\Resources;

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
        return [
            'conversation_id' => $this->conversation_id,
            'created_by' => $this->created_by,
            'character_id' => $this->character_id,
            'user_id' => $this->user_id,
        ];
    }
}
