<?php

namespace App\Services;

use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CategoryStatus;
use App\Models\EntityType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryStatusService
{
    public const LIMIT = 10;

    public static function definitionRules(): array
    {
        return [
            'label' => ['required', 'string', 'max:45'],
            'icon' => ['nullable', 'string', 'max:100', 'regex:/^(?:(?:fa-regular|fa-solid|fa-light|fa-thin|fa-duotone|fa-brands) )?fa-[a-z0-9-]+$/'],
            'is_default' => ['sometimes', 'boolean'],
        ];
    }

    public function sync(Campaign $campaign, EntityType $category, array $definitions, bool $complete = true): array
    {
        $this->authorizeCategory($campaign, $category);

        return DB::transaction(function () use ($campaign, $category, $definitions, $complete): array {
            EntityType::whereKey($category->id)->lockForUpdate()->firstOrFail();
            $existing = $category->statuses()->where('campaign_id', $campaign->id)->get()->keyBy('id');
            Validator::make(['statuses' => $definitions], [
                'statuses' => ['array', 'max:' . self::LIMIT],
                'statuses.*' => ['array:id,label,icon,is_default'],
                'statuses.*.id' => ['nullable', 'integer', 'distinct'],
                'statuses.*.label' => self::definitionRules()['label'],
                'statuses.*.icon' => self::definitionRules()['icon'],
                'statuses.*.is_default' => ['sometimes', 'boolean'],
            ])->validate();

            $ids = collect($definitions)->pluck('id')->filter()->map(fn ($id) => (int) $id);
            if ($ids->diff($existing->keys())->isNotEmpty() || ($complete && $existing->keys()->diff($ids)->isNotEmpty())) {
                throw ValidationException::withMessages(['statuses' => __('Statuses have changed. Reload this page before saving. Use the delete action to remove an existing status.')]);
            }
            if ($existing->count() + count($definitions) - $ids->count() > self::LIMIT) {
                throw ValidationException::withMessages(['statuses' => __('A category can have at most :count statuses.', ['count' => self::LIMIT])]);
            }

            $labels = $existing->map(fn ($status) => Str::lower(mb_trim($status->name())))->except($ids->all())->values()->all();
            $defaultCount = 0;
            foreach ($definitions as $definition) {
                $label = mb_trim($definition['label']);
                if ($label === '' || in_array(Str::lower($label), $labels, true)) {
                    throw ValidationException::withMessages(['statuses' => __('Status labels must be non-empty and unique within a category.')]);
                }
                $labels[] = Str::lower($label);
                $defaultCount += (int) ($definition['is_default'] ?? false);
            }
            if ($defaultCount > 1) {
                throw ValidationException::withMessages(['statuses' => __('Choose at most one default status.')]);
            }
            if ($complete || $defaultCount === 1) {
                $keepDefault = collect($definitions)->filter(fn ($definition) => ! empty($definition['is_default']))->pluck('id')->filter()->all();
                $category->statuses()->whereNotIn('id', $keepDefault)->update(['is_default' => false]);
            }

            $saved = [];
            foreach (array_values($definitions) as $position => $definition) {
                $status = ! empty($definition['id']) ? $existing->get((int) $definition['id']) : new CategoryStatus;
                if (! $status->exists) {
                    $status->campaign_id = $campaign->id;
                    $status->category_id = $category->id;
                    $key = Str::limit(Str::slug($definition['label'], '_') ?: 'status', 35, '');
                    $candidate = $key;
                    for ($suffix = 2; $category->statuses()->where('key', $candidate)->exists(); $suffix++) {
                        $candidate = $key . '_' . $suffix;
                    }
                    $status->key = $candidate;
                    $status->sort_order = $existing->count() + $position;
                }
                if ($complete) {
                    $status->sort_order = $position;
                }
                $status->label = mb_trim($definition['label']);
                $status->icon = $definition['icon'] ?? null;
                $status->is_default = (bool) ($definition['is_default'] ?? false);
                $status->save();
                $saved[] = $status;
            }
            $this->invalidate($campaign);

            return $saved;
        });
    }

    public function reorder(Campaign $campaign, EntityType $category, array $ids): void
    {
        $this->authorizeCategory($campaign, $category);
        DB::transaction(function () use ($campaign, $category, $ids): void {
            EntityType::whereKey($category->id)->lockForUpdate()->firstOrFail();
            $statuses = $category->statuses()->where('campaign_id', $campaign->id)->get();
            if (count($ids) !== $statuses->count() || count(array_unique($ids)) !== count($ids) || $statuses->pluck('id')->diff($ids)->isNotEmpty()) {
                throw ValidationException::withMessages(['ids' => __('Supply every status in this category exactly once.')]);
            }
            foreach (array_values($ids) as $position => $id) {
                $category->statuses()->whereKey($id)->update(['sort_order' => $position]);
            }
            $this->invalidate($campaign);
        });
    }

    public function delete(Campaign $campaign, EntityType $category, CategoryStatus $status, array $data): void
    {
        $this->authorizeCategory($campaign, $category);
        abort_unless($status->category_id === $category->id && $status->campaign_id === $campaign->id, 404);
        DB::transaction(function () use ($campaign, $category, $status, $data): void {
            EntityType::whereKey($category->id)->lockForUpdate()->firstOrFail();
            $status = $category->statuses()->whereKey($status->id)->firstOrFail();
            $replacement = $data['replacement_id'] ?? null;
            if ($replacement !== null && (! $category->statuses()->where('campaign_id', $campaign->id)->whereKey($replacement)->exists() || (int) $replacement === $status->id)) {
                throw ValidationException::withMessages(['replacement_id' => __('Choose another status in this category.')]);
            }
            $assigned = DB::table('entities')->where('campaign_id', $campaign->id)->where('status_id', $status->id);
            if ($replacement === null && empty($data['clear']) && $assigned->exists()) {
                throw ValidationException::withMessages(['clear' => __('Explicitly replace or clear assigned statuses before deleting.')]);
            }
            $assigned->update(['status_id' => $replacement]);
            if ($status->is_default && $replacement !== null) {
                $category->statuses()->update(['is_default' => false]);
                $category->statuses()->whereKey($replacement)->update(['is_default' => true]);
            }
            $this->replaceFilters($campaign, $status->id, $replacement === null ? null : (int) $replacement);
            $status->delete();
            foreach ($category->statuses()->get() as $position => $remaining) {
                $remaining->update(['sort_order' => $position]);
            }
            $this->invalidate($campaign);
        });
    }

    public function authorizeCategory(Campaign $campaign, EntityType $category): void
    {
        abort_unless($category->isCustom() && $category->campaign_id === $campaign->id, 404);
        if (! $campaign->premium()) {
            throw new AuthorizationException(__('This feature is only available on premium campaigns'));
        }
    }

    private function replaceFilters(Campaign $campaign, int $old, ?int $replacement): void
    {
        foreach (DB::table('bookmarks')->where('campaign_id', $campaign->id)->whereNotNull('filters')->get(['id', 'filters']) as $bookmark) {
            $filters = $this->replaceFilter($bookmark->filters, $old, $replacement);
            if ($filters !== $bookmark->filters) {
                DB::table('bookmarks')->where('id', $bookmark->id)->update(['filters' => $filters]);
            }
        }
        foreach (DB::table('campaign_dashboard_widgets')->where('campaign_id', $campaign->id)->whereNotNull('config')->get(['id', 'config']) as $widget) {
            $config = json_decode($widget->config, true);
            if (! is_string($config['filters'] ?? null)) {
                continue;
            }
            $filters = $this->replaceFilter($config['filters'], $old, $replacement);
            if ($filters !== $config['filters']) {
                $config['filters'] = $filters;
                DB::table('campaign_dashboard_widgets')->where('id', $widget->id)->update(['config' => json_encode($config)]);
            }
        }
    }

    private function replaceFilter(string $filters, int $old, ?int $replacement): string
    {
        parse_str($filters, $params);
        if (! isset($params['status_id'])) {
            return $filters;
        }
        $changed = false;
        $replace = function ($value) use ($old, $replacement, &$changed) {
            if ((string) $value !== (string) $old) {
                return $value;
            }
            $changed = true;

            return $replacement === null ? 'deleted:' . $old : (string) $replacement;
        };
        $params['status_id'] = is_array($params['status_id']) ? array_map($replace, $params['status_id']) : $replace($params['status_id']);

        return $changed ? http_build_query($params) : $filters;
    }

    private function invalidate(Campaign $campaign): void
    {
        DB::afterCommit(function () use ($campaign): void {
            CampaignCache::campaign($campaign)->clear()->clearSidebar();
        });
    }
}
