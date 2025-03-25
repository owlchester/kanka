<?php

namespace App\Livewire\Roadmap;

use App\Jobs\Discord\UpdateFeatureUpvotes;
use App\Models\Feature;
use App\Models\FeatureVote;
use Livewire\Component;

class Upvote extends Component
{
    public Feature $feature;

    public int $count;

    public bool $isGuest = false;

    public bool $isUnsubbed = false;

    public bool $col;

    public function mount(Feature $feature, bool $col = true)
    {
        $this->feature = $feature;
        $this->count = $feature->upvote_count;
        $this->col = $col;
    }

    public function upvote(): void
    {
        if (auth()->guest()) {
            $this->isGuest = true;

            return;
        } elseif (! auth()->user()->can('vote', $this->feature)) {
            $this->isUnsubbed = true;

            return;
        }

        /** @var FeatureVote $vote */
        $vote = FeatureVote::where('user_id', auth()->user()->id)
            ->where('feature_id', $this->feature->id)
            ->firstOrNew();
        if ($vote->exists) {
            $vote->delete();
            $this->feature->upvote_count--;
            $this->feature->updateQuietly();
            $this->count--;
        } else {
            $vote->feature_id = $this->feature->id;
            $vote->user_id = auth()->user()->id;
            $vote->save();
            $this->feature->upvote_count++;
            $this->feature->updateQuietly();
            $this->count++;
        }

        UpdateFeatureUpvotes::dispatch($this->feature->id);
    }

    public function render()
    {
        return view('livewire.roadmap.upvote');
    }
}
