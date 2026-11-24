<?php

namespace App\Services\Entity;

use App\Models\EntityType;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RecoverySetupService
{
    use CampaignAware;
    use UserAware;

    public function setup(): array
    {
        return [
            'acl' => [
                'premium' => $this->campaign->boosted(),
            ],
            'elements' => $this->elements(),
            'i18n' => $this->i18n(),
            'api' => [
                'recovery' => route('recovery.save', [$this->campaign]),
            ],
            'upgrade' => $this->upgradeLink(),
        ];
    }

    protected function elements(): array
    {
        $moduleNames = [];
        $moduleIcons = [];
        foreach (EntityType::inCampaign($this->campaign)->get() as $entityType) {
            $moduleNames[$entityType->id] = $entityType->name();
            $moduleIcons[$entityType->id] = $entityType->icon() ?: 'fa-regular fa-cube';
        }

        $elements = DB::select(
            "select e.id, e.name, e.deleted_at, e.deleted_by, e.type_id, t.code as type, null as parent_name
                from entities as e
                left join entity_types as t on t.id = e.type_id
                where e.deleted_at is not null and e.campaign_id = ?
                union all
                select p.id, p.name, p.deleted_at, p.deleted_by, 0 as type_id, 'post' as type, e.name as parent_name
                from posts as p
                left join entities as e on e.id = p.entity_id
                where p.deleted_at is not null and e.deleted_at is null and e.campaign_id = ?
                order by deleted_at DESC",
            [$this->campaign->id, $this->campaign->id]
        );

        $deletedByIds = array_values(array_unique(array_filter(
            array_map(fn (object $element): ?int => $element->deleted_by !== null ? (int) $element->deleted_by : null, $elements),
            fn (?int $id): bool => $id !== null
        )));

        $users = $deletedByIds !== []
            ? User::query()->whereIn('id', $deletedByIds)->pluck('name', 'id')->all()
            : [];

        $unknownUser = __('crud.history.unknown');
        $today = now()->startOfDay();
        $data = [];

        foreach ($elements as $key => $element) {
            $deletedAt = Carbon::parse($element->deleted_at);
            $isPost = $element->type === 'post';
            $retentionDays = (int) config($isPost ? 'entities.hard_delete_posts' : 'entities.hard_delete', 30);
            $expiresAt = $deletedAt->copy()->addDays($retentionDays);
            $daysLeft = max(0, (int) $today->diffInDays($expiresAt->copy()->startOfDay(), false));
            $deletedBy = $element->deleted_by !== null ? (int) $element->deleted_by : null;
            $typeId = (int) $element->type_id;

            $data[] = [
                'id' => (int) $element->id,
                'name' => (string) $element->name,
                'deleted_at' => (string) $element->deleted_at,
                'deleted_at_formatted' => $deletedAt->toDateTimeString(),
                'deleted_at_timestamp' => $deletedAt->timestamp,
                'days_left' => $daysLeft,
                'expires_label' => trans_choice('campaigns/recovery.fields.days_left', $daysLeft, ['count' => $daysLeft]),
                'expires_tooltip' => __('campaigns/recovery.fields.expires_tooltip', ['date' => $expiresAt->toFormattedDateString()]),
                'deleted_by' => $deletedBy,
                'deleted_name' => $deletedBy !== null ? ($users[$deletedBy] ?? $unknownUser) : $unknownUser,
                'date' => $deletedAt->diffForHumans(),
                'position' => $key,
                'type' => $isPost ? 'post' : 'entity',
                'type_id' => $typeId,
                'type_name' => $isPost
                    ? __('entities.article')
                    : Arr::get($moduleNames, $typeId, $unknownUser),
                'icon' => $isPost
                    ? 'fa-duotone fa-pen'
                    : Arr::get($moduleIcons, $typeId, 'fa-regular fa-cube'),
                'parent_name' => $element->parent_name,
            ];
        }

        return $data;
    }

    protected function i18n(): array
    {
        $translations = [
            'model_0' => __('entities.article'),
            'order_by_newest' => __('campaigns/recovery.order.newest'),
            'order_by_oldest' => __('campaigns/recovery.order.oldest'),
            'order_by_type' => __('campaigns/recovery.order.type'),
            'select_all' => __('general.select_all'),
            'deselect_all' => __('general.deselect_all'),
            'empty' => __('campaigns/recovery.empty'),
            'empty_title' => __('campaigns/recovery.empty_title'),
            'error' => __('campaigns/recovery.error'),
            'recover' => __('campaigns/recovery.actions.recover'),
            'restore_selected' => __('campaigns/recovery.actions.recover_selected'),
            'newest' => __('campaigns/recovery.order.newest_first'),
            'oldest' => __('campaigns/recovery.order.oldest_first'),
            'type' => __('campaigns/recovery.order.type_order'),
            'name_asc' => __('campaigns/recovery.order.name_asc'),
            'premium_title' => __('campaigns/recovery.cta.title'),
            'premium' => __('campaigns/recovery.cta.lead'),
            'upgrade' => $this->canEnablePremium()
                ? __('callouts.alert.enable', ['campaign' => $this->campaign])
                : __('callouts.actions.subscription'),
            'confirm' => __('crud.actions.confirm'),
            'deleted_at' => __('campaigns/recovery.fields.deleted_at', ['date' => 'placeholder', 'user' => 'placeholder']),
            'recovery_success' => __('campaigns/recovery.name_link', ['name' => '<a href="placeholder" class="text-link">placeholder</a>']),
            'search' => __('campaigns/recovery.filters.search'),
            'filter_all_types' => __('campaigns/recovery.filters.all_types'),
            'filter_all_users' => __('campaigns/recovery.filters.all_users'),
            'filter_all_dates' => __('campaigns/recovery.filters.all_dates'),
            'filter_last_24h' => __('campaigns/recovery.filters.last_24h'),
            'filter_last_7d' => __('campaigns/recovery.filters.last_7d'),
            'filter_last_30d' => __('campaigns/recovery.filters.last_30d'),
            'filter_expiring_soon' => __('campaigns/recovery.filters.expiring_soon'),
            'filter_clear' => __('campaigns/recovery.filters.clear'),
            'filter_deleted_by' => __('campaigns/recovery.filters.deleted_by'),
            'filter_type' => __('campaigns/recovery.filters.type'),
            'filter_timeframe' => __('campaigns/recovery.filters.timeframe'),
            'filter_sort' => __('campaigns/recovery.filters.sort'),
            'no_results_title' => __('campaigns/recovery.no_results_title'),
            'no_results' => __('campaigns/recovery.no_results'),
            'showing_count' => __('campaigns/recovery.showing_count'),
            'parent_entity' => __('campaigns/recovery.fields.parent_entity'),
            'recovered_badge' => __('campaigns/recovery.recovered_badge'),
            'view_recovered' => __('campaigns/recovery.view_recovered'),
        ];

        // Modules
        $modules = config('entities.ids');
        foreach ($modules as $name => $id) {
            $moduleName = __('entities.' . $name);
            if ($this->campaign->superboosted() && $this->campaign->hasModuleName($id)) {
                $moduleName = $this->campaign->moduleName($id);
            }
            $translations['model_' . $id] = $moduleName;
        }

        return $translations;
    }

    protected function upgradeLink(): ?string
    {
        if ($this->campaign->boosted()) {
            return null;
        }

        if ($this->canEnablePremium()) {
            return route('settings.premium', [
                'campaign' => $this->campaign->id,
                'f' => 'cta',
                's' => 'recovery',
            ]);
        }

        return route('settings.subscription', [
            'f' => 'cta',
            's' => 'recovery',
            'w' => $this->campaign->id,
        ]);
    }

    protected function canEnablePremium(): bool
    {
        return $this->user->can('boost', $this->user);
    }
}
