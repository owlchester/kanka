<?php

namespace App\Services\Attributes;

use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EntitySheetService
{
    use CampaignAware;
    use EntityAware;

    protected ?Entity $copySource = null;

    public function copySource(?Entity $entity): self
    {
        $this->copySource = $entity;

        return $this;
    }

    public function sync(array $sheets): void
    {
        $existingSheets = $this->entity->sheets()->get()->keyBy('id');
        $resolved = [];
        $plugins = null;

        foreach ($sheets as $order => $raw) {
            $sheet = json_decode($raw, true);
            Validator::make($sheet ?? [], [
                'id' => ['nullable', 'integer'],
                'source' => ['required', 'in:legacy,marketplace'],
                'reference' => ['required', 'string', 'max:255'],
            ])->validate();

            $existing = $existingSheets->get($sheet['id'] ?? 0);
            if ($existing) {
                if ($existing->source !== $sheet['source'] || $existing->reference !== $sheet['reference']) {
                    throw ValidationException::withMessages(['sheets' => __('The selected sheet is invalid.')]);
                }
                $resolved[] = ['source' => $existing->source, 'reference' => $existing->reference, 'sort_order' => $order];

                continue;
            }

            $copiedSheet = $this->copySource?->campaign_id === $this->campaign->id
                && $this->copySource->type_id === $this->entity->type_id
                && $this->copySource->sheets()
                    ->where('source', $sheet['source'])
                    ->where('reference', $sheet['reference'])
                    ->exists();
            if ($copiedSheet) {
                $resolved[] = [
                    'source' => $sheet['source'],
                    'reference' => $sheet['reference'],
                    'sort_order' => $order,
                ];

                continue;
            }

            if ($sheet['source'] !== 'marketplace'
                || ! $this->campaign->boosted()
                || ! config('marketplace.enabled')) {
                throw ValidationException::withMessages(['sheets' => __('The selected sheet is unavailable.')]);
            }

            $plugins ??= CampaignPlugin::templates($this->campaign)
                ->select('campaign_plugins.*')
                ->with(['plugin', 'version'])
                ->get();
            $plugin = $plugins->first(fn (CampaignPlugin $plugin) => $plugin->version?->uuid === $sheet['reference'] && $plugin->renderable());
            if (! $plugin) {
                throw ValidationException::withMessages(['sheets' => __('The selected sheet is unavailable.')]);
            }
            $resolved[] = ['source' => 'marketplace', 'reference' => $plugin->version->uuid, 'sort_order' => $order];
        }

        $resolved = collect($resolved)->unique(fn (array $sheet) => $sheet['source'] . ':' . $sheet['reference'])->values();
        $this->entity->sheets()->delete();
        foreach ($resolved as $sheet) {
            $this->entity->sheets()->create($sheet);
        }
    }
}
