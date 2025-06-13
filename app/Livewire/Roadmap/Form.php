<?php

namespace App\Livewire\Roadmap;

use App\Enums\FeatureStatus;
use App\Models\Feature;
use App\Models\FeatureFile;
use App\Models\FeatureVote;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    #[Validate('image|nullable|max:3072')] // 3MB Max
    public $file;

    #[Validate('required|min:5')]
    public string $title = '';

    #[Validate('required|min:5')]
    public string $description = '';

    public bool $success = false;

    public int $iteration = 0;

    public $duplicates;

    public function save()
    {
        $this->authorize('create', Feature::class);
        $this->validate();

        $feat = new Feature;
        $feat->created_by = auth()->user()->id;
        $feat->name = $this->title;
        $feat->description = $this->description;
        $feat->status_id = FeatureStatus::Draft;
        $feat->save();

        if (auth()->user()->can('vote', $feat)) {
            /** @var FeatureVote $vote */
            $vote = new FeatureVote;
            $vote->feature_id = $feat->id;
            $vote->user_id = auth()->user()->id;
            $vote->save();
            $feat->upvote_count++;
            $feat->updateQuietly();
        }

        if ($this->file) {
            $file = $this->file->storeAs('features/' . $feat->id, uniqid() . '.' . $this->file->getClientOriginalExtension(), 's3');
            $featFile = new FeatureFile;
            $featFile->feature_id = $feat->id;
            $featFile->path = $file;
            $featFile->save();
        }

        $this->success = true;
        $this->title = '';
        $this->description = '';
        $this->file = null;
        $this->iteration++;
    }

    public function updated()
    {
        if (empty($this->title)) {
            return;
        }

        $titles = explode(' ', $this->title);
        $words = [];
        $base = Feature::approved();
        foreach ($titles as $word) {
            // Let's try and skip small descriptive words
            if (mb_strlen($word) <= 4) {
                continue;
            }
            $words[] = $word;
        }
        if (empty($words)) {
            return;
        }
        $base->where(function ($sub) use ($words) {
            foreach ($words as $word) {
                $sub->orWhere('name', 'like', '%' . $word . '%');
            }

            return $sub;
        });

        $this->duplicates = $base->limit(5)->get();
    }

    public function open(Feature $feature)
    {
        $this->dispatch('open-idea', idea: $feature->id);
    }

    public function render()
    {
        return view('livewire.roadmap.form');
    }
}
