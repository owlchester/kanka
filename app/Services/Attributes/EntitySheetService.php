<?php

namespace App\Services\Attributes;

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EntitySheetService
{
    public function sync(Entity $entity, Campaign $campaign, array $sheets): void
    {
        $existingSheets = $entity->sheets()->get()->keyBy('id');
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

            if ($sheet['source'] !== 'marketplace'
                || ! $campaign->boosted()
                || ! config('marketplace.enabled')) {
                throw ValidationException::withMessages(['sheets' => __('The selected sheet is unavailable.')]);
            }

            $plugins ??= CampaignPlugin::templates($campaign)
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
        $entity->sheets()->delete();
        foreach ($resolved as $sheet) {
            $entity->sheets()->create($sheet);
        }
    }
}
