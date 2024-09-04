<?php

namespace App\Services\Entity;

use App\Services\Gallery\StorageService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;

class RecoverySetupService
{
    use CampaignAware;
    use UserAware;

    protected array $elements;
    protected ?string $term;
    protected ?string $nextPage;
    protected array $filters;

    protected StorageService $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function term(?string $term): self
    {
        $this->term = $term;
        return $this;
    }

    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function setup(): array
    {
        return [
            'acl' => [
                'premium' => $this->campaign->boosted()
            ],
            'elements' => $this->elements(),
            'i18n' => $this->i18n(),
            'api' => [
                'search' => route('gallery.search', [$this->campaign]),
                'recovery' => route('recovery.save', [$this->campaign]),
            ],
            'upgrade' => $this->upgradeLink()
        ];
    }

    public function search(): array
    {
        return [
            'elements' => $this->elements()
        ];
    }

    protected function elements(): array
    {
        $elements = DB::select(
            'select id, name, deleted_at, deleted_by, type_id, "entity" as type
                from entities
                where deleted_at is not null and campaign_id = ' . $this->campaign->id . '
                union all
                select p.id, p.name, p.deleted_at, p.deleted_by, 0 as type_id, "post" as type
                from posts as p
                left join entities as e on e.id = p.entity_id
                where p.deleted_at is not null and e.deleted_at is null and e.campaign_id = ' . $this->campaign->id .
                ' order by deleted_at DESC'
        );

        $users = $this->campaign->users()->pluck('users.name', 'users.id')->toArray();
        foreach ($elements as $key => $element) {
            $element->deleted_name = $users[$element->deleted_by] ?? 'Unknown';
            $element->date = \Carbon\Carbon::createFromTimeStamp(strtotime($element->deleted_at))->diffForHumans();
            $element->position = $key;
        }
        //This will cast each object in the array to an array, and the toArray gets you from the collection back to an array.
        return collect($elements)->map(function ($x) { return (array) $x; })->toArray();
    }

    protected function i18n(): array
    {
        $translations = [
            'model_0' => __('entities.post'),
            'order_by_newest' => __('campaigns/recovery.order.newest'),
            'order_by_oldest' => __('campaigns/recovery.order.oldest'),
            'order_by_type' => __('campaigns/recovery.order.type'),
            'select_all' => __('general.select_all'),
            'deselect_all' => __('general.deselect_all'),
            'recover'       => __('campaigns/recovery.actions.recover'),
            'restore_selected' => __('campaigns/recovery.actions.recover_selected'),
            'newest'  => __('campaigns/recovery.order.newest_first'),
            'oldest'  => __('campaigns/recovery.order.oldest_first'),
            'type'  => __('campaigns/recovery.order.type_order'),
            'premium_title' =>  __('callouts.premium.title'),
            'premium' => __('campaigns/recovery.premium'),
            'upgrade'  => __('cookieconsent.link'),
            'confirm' => __('crud.click_modal.confirm'),
            'deleted_at' => __('campaigns/recovery.fields.deleted_at', ['date' => 'placeholder', 'user' => 'placeholder']),
            'recovery_success' => __('campaigns/recovery.name_link', ['name' => '<a href="placeholder">placeholder</a>']),

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
        return route('settings.premium');
    }
}
