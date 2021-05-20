<?php

namespace App\Http\Resources;

use App\Models\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Conversation $model */
        $model = $this->resource;

        return $this->entity([
            'type' => $model->type,
            'target' => $model->target,
            'is_closed' => $model->is_closed,
            'participants' => $model->participants()->count(),
            'messages' => $model->messages()->count(),
        ]);
    }
}
