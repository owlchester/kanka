<?php

namespace App\Http\Resources;

use App\Models\CommunityVote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var CommunityVote $model */
        $model = $this->resource;

        $data = [
            'id' => $model->id,
            'name' => $model->name,
            'excerpt' => $model->excerpt,
            'content' => $model->content,
            'options' => $model->options(),
            'voting' => $model->isVoting(),
            'slug' => $model->getSlug(),
            'published' => $model->visible_at->isoFormat('MMMM D, Y'),
            'until' => $model->published_at->isoFormat('MMMM D, Y'),
            'valid_ballots' => $model->ballots->count(),
        ];

        $ballots = [];
        foreach ($model->options() as $key => $text) {
            $ballots[$key] = $model->ballotWidth($key);
        }
        $data['ballots'] = $ballots;

        return $data;
    }
}
