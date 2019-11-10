<?php


namespace App\Http\Resources\Conversation;

use App\Models\ConversationMessage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $oldest = $request->get('oldest', null);
        $newest = $request->get('newest', null);

        $messages = new Collection($this->messages()->default($oldest, $newest)->get());
        $messages = $messages->reverse();

        $data = [];
        /** @var ConversationMessage $message */
        foreach ($messages as $message) {
            $data[] = new ConversationMessageResource($message);
//            [
//                'id' => $message->id,
//                'user' => $message->user ? $message->user->name : null,
//                'character' => $message->character ? $message->character->name : null,
//                'message' => $message->message,
//                'created_at' => $message->created_at->diffForHumans(),
//                'can_delete' => Auth::user()->can('delete', $message),
//                'can_edit' => Auth::user()->can('edit', $message),
//                'delete_url' => route('conversations.conversation_messages.destroy', [$this, $message]),
//                'is_updated' => $message->updated_at !== $message->created_at
//            ];
        }

        // Check if there are previous messages available
        $first = $messages->first();
        $previous = false;
        if ($first) {
            $previous = $this->messages()->where('id', '<', $first->id)->count() > 0;
        }

        return [
            'messages' => $data,
            'previous' => $previous,
        ];
    }
}