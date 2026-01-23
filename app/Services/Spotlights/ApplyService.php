<?php

namespace App\Services\Spotlights;

use App\Enums\SpotlightContentStatus;
use App\Events\SpotlightSubmitted;
use App\Models\SpotlightContent;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class ApplyService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    protected ?SpotlightContent $content;

    public function content(): ?SpotlightContent
    {
        return SpotlightContent::where('campaign_id', $this->campaign->id)->first();
    }

    public function save()
    {
        $this->content = $this->content();
        if (!$this->content?->isDraft()) {
            return;
        }
        $this->fill();
        $this->content->save();
    }

    public function apply()
    {
        $this->content = $this->content();
        $this->fill();
        $this->content->status = SpotlightContentStatus::applied;
        $this->content->save();

        SpotlightSubmitted::dispatch($this->content);
    }

    public function retract()
    {
        $this->content = $this->content();
        if (empty($this->content)) {
            return;
        }
        if ($this->content->status !== SpotlightContentStatus::applied) {
            return;
        }
        $this->content->status = SpotlightContentStatus::draft;
        $this->content->save();
    }

    public function fill()
    {
        if (empty($this->content)) {
            $this->content = new SpotlightContent;
            $this->content->campaign_id = $this->campaign->id;
            $this->content->status = SpotlightContentStatus::draft;
        }

        $this->content->content_json = $this->request->only([
            'time',
            'world',
            'proud',
            'inspiration',
            'stories',
            'kanka',
            'share'
        ]);
    }
}
