<?php

namespace App\Http\Resources\Conversation;

use App\Facades\CampaignLocalization;
use App\Models\ConversationMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationMessageResource extends JsonResource
{
    public function toArray($request)
    {
        $campaign = CampaignLocalization::getCampaign();
        /** @var ConversationMessage $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'from_id' => $resource->user_id ?: $resource->character_id,
            'user' => $resource->user?->name,
            'character' => $resource->character?->name,
            'message' => $resource->message,
            'created_at' => $resource->created_at->diffForHumans(),
            'updated_at' => $resource->updated_at->diffForHumans(),
            'created_by' => $resource->created_by,
            'can_delete' => auth()->check() && auth()->user()->can('delete', $resource),
            'can_edit' => auth()->check() && auth()->user()->can('edit', $resource),
            'delete_url' => route('conversations.conversation_messages.destroy', [$campaign, $resource->conversation_id, $resource->id]),
            'is_updated' => $resource->updated_at != $resource->created_at,
            'group' => $resource->isGroup(),
        ];
    }
}
