<?php

namespace App\Http\Resources\Conversation;

use App\Models\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    private const PAGE_SIZE = 20;

    public function toArray($request): array
    {
        /** @var Conversation $resource */
        $resource = $this->resource;
        $query = $resource->messages()->with('participant')->limit(self::PAGE_SIZE + 1);
        $forward = $request->filled('newest');
        if ($forward) {
            $query->where('id', '>', $request->integer('newest'))->oldest('id');
        } else {
            $query->latest('id');
            if ($request->filled('oldest')) {
                $query->where('id', '<', $request->integer('oldest'));
            }
        }

        $results = $query->get();
        $more = $results->count() > self::PAGE_SIZE;
        $messages = $results->take(self::PAGE_SIZE);

        return [
            'messages' => ConversationMessageResource::collection($forward ? $messages : $messages->reverse()->values()),
            ...($forward ? ['more_newer' => $more] : ['previous' => $more]),
        ];
    }
}
