<?php

namespace App\Services\Entity;

use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Gallery\StorageService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Barryvdh\Reflection\DocBlock\Type\Collection;
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
            $element->deleted_name = isset($users[$element->deleted_by]) ? $users[$element->deleted_by] : 'Unknown';
            $element->date = \Carbon\Carbon::createFromTimeStamp(strtotime($element->deleted_at))->diffForHumans();
            $element->position = $key;
        }
        return collect($elements)->map(function($x){ return (array) $x; })->toArray(); 
    }

    protected function i18n(): array
    {
        $translations = [
            '0' => __('entities.post'),
            'filters' => __('bookmarks.fields.filters'),
            'new_folder' => __('campaigns/gallery.uploader.new_folder'),
            'select' => __('crud.select'),
            'select_all' => 'Select all',
            'deselect_all' => 'Cancel selection',
            'restore'       => 'Restore',
            'restore_selected' => 'Restore selected',
            'cancel' => __('crud.cancel'),
            'remove' => __('crud.remove'),
            'create' => __('crud.create'),
            'update' => __('crud.update'),
            'move' => __('crud.actions.move'),
            'home' => __('Home'),
            'load_more' => __('Load more'),
            
            'recover' => 'recover',
            'newest'  => 'newest first',
            'oldest'  => 'oldest first',
            'type'  => 'type',

            // Space
            'storage' => __('campaigns/gallery.storage.title'),
            'of' => __('campaigns/gallery.storage.of'),
            'upgrade' => __('campaigns/gallery.actions.upgrade'),

            // Files
            'details' => __('campaigns/gallery.fields.details'),
            'used_in' => __('campaigns/gallery.fields.used_in'),
            'unused' => __('campaigns/gallery.fields.unused'),
            'name' => __('crud.fields.name'),
            'delete' => __('crud.remove'),
            'save' => __('crud.save'),
            'saved' => __('gallery.file.saved'),
            'confirm' => __('crud.click_modal.confirm'),
            'visibility' => __('crud.fields.visibility'),
            'size' => __('campaigns/gallery.fields.size'),
            'file_type' => __('campaigns/gallery.fields.file_type'),
            'uploaded_by' => __('campaigns/gallery.fields.created_by'),
            'focus_point' => __('campaigns/gallery.actions.focus_point'),
            'link' => __('campaigns/gallery.fields.link'),
            'open' => __('crud.actions.open'),
            'focus_locked' => __('campaigns/gallery.focus.locked'),
            'folder' => __('campaigns/gallery.fields.folder'),

            'change' => __('crud.actions.change'),

            // Filters
            'filter_only_unused' => __('gallery.filters.only_unused'),

            'visibility.1' => __('crud.visibilities.all'),
            'visibility.2' => __('crud.visibilities.admin'),
            'visibility.3' => __('crud.visibilities.admin-self'),
            'visibility.4' => __('crud.visibilities.self'),
            'visibility.5' => __('crud.visibilities.members'),
        ];

        $modules = config('entities.ids');
        foreach ($modules as $name => $id) {
            $moduleName = __('entities.' . $name);
            if ($this->campaign->superboosted() && $this->campaign->hasModuleName($id)) {
                $moduleName = $this->campaign->moduleName($id);
            }
            $translations[$id] = $moduleName;
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
