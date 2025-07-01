<?php

namespace App\Services\Gallery;

use App\Enums\Visibility;
use App\Facades\Limit;
use App\Http\Resources\GalleryFile;
use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SetupService
{
    use CampaignAware;
    use UserAware;

    protected Collection $files;

    protected Image $image;

    protected ?string $term;

    protected ?string $nextPage;

    protected array $filters;

    protected array $sort;

    protected StorageService $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function image(Image $image): self
    {
        $this->image = $image;

        return $this;
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

    public function sort(array $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function setup(): array
    {
        return [
            'acl' => [
                'manage' => $this->user->can('galleryManage', $this->campaign),
                'upload' => $this->user->can('galleryUpload', $this->campaign),
                'premium' => $this->campaign->boosted(),
            ],
            'files' => $this->files(),
            'i18n' => $this->i18n(),
            'folders' => $this->folders(),
            'api' => [
                'search' => route('gallery.search', [$this->campaign]),
                'delete' => route('gallery.delete', [$this->campaign]),
                'create' => route('gallery.create', [$this->campaign]),
                'update' => route('gallery.update', [$this->campaign]),
                'upload' => route('gallery.upload.files', [$this->campaign]),
            ],
            'next' => $this->nextPage ?? null,
            'visibilities' => $this->visibilities(),
            'bulkVisibilities' => $this->visibilities(true),
            'url' => route('gallery', $this->campaign),
            'space' => $this->space(),
            'upgrade' => $this->upgradeLink(),
        ];
    }

    /**
     * Open a file
     */
    public function open(): array
    {
        return [
            'folder' => $this->image,
            'files' => $this->files(),
            'breadcrumbs' => $this->breadcrumbs(),
            'next' => $this->nextPage ?? null,
            'url' => route('gallery', [$this->campaign, 'folder' => $this->image->id]),
        ];
    }

    public function search(): array
    {
        return [
            'files' => $this->files(),
            'next' => $this->nextPage ?? null,
        ];
    }

    protected function files(): array
    {
        $this->files = new Collection;
        $query = $this
            ->campaign
            ->images()
            ->with(['images', 'creator']);

        if (isset($this->sort) && Arr::has($this->sort, 'sort') && in_array($this->sort['sort'], ['asc', 'desc'])) {
            $query->sortOrder($this->sort['sort']);
        } else {
            $query->defaultOrder();
        }

        if (isset($this->filters) && Arr::has($this->filters, 'unused')) {
            $query
                ->distinct()
                ->select('images.*')
                ->leftJoin('image_mentions as im', 'im.image_id', 'images.id')
                ->leftJoin('entities as e', 'e.image_uuid', 'images.id')
                ->whereNull('im.id')
                ->whereNull('e.id')
                ->where('is_folder', false);
        }

        if (isset($this->term)) {
            $query->named($this->term);
        } else {
            $query->imageFolder(isset($this->image) ? $this->image->id : null);
        }

        $files = $query->paginate(25);
        /** @var Image $file */
        foreach ($files as $file) {
            $fileData = (new GalleryFile($file))->campaign($this->campaign);
            $this->files->add($fileData);
        }

        if ($files->hasMorePages()) {
            $this->nextPage = $files->appends($this->filters ?? null)->nextPageUrl();
        }

        return $this->files->toArray();
    }

    protected function i18n(): array
    {
        return [
            'filters' => __('bookmarks.fields.filters'),
            'new_folder' => __('campaigns/gallery.uploader.new_folder'),
            'select' => __('crud.select'),
            'cancel' => __('crud.cancel'),
            'remove' => __('crud.remove'),
            'create' => __('crud.create'),
            'update' => __('crud.update'),
            'move' => __('crud.actions.move'),
            'home' => __('Home'),
            'load_more' => __('Load more'),
            'upload_hint' => __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, woff2', 'size' => Limit::readable()->upload()]),

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
            'confirm' => __('crud.actions.confirm'),
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

            'sort' => __('gallery.filters.sort'),
            'sort_asc' => __('crud.filters.sorting.asc', ['field' => 'Name']),
            'sort_desc' => __('crud.filters.sorting.desc', ['field' => 'Name']),
            'sort_default' => __('dashboard.widgets.orders.recent'),
        ];
    }

    protected function folders(): array
    {
        $folders = [
            '' => '',
            0 => __('gallery.update.home'),
        ];
        $query = $this
            ->campaign
            ->images()
            ->select(['id', 'name'])
            ->folders()
            ->get();
        /** @var Image $folder */
        foreach ($query as $folder) {
            $folders[$folder->id] = $folder->name;
        }

        return $folders;
    }

    protected function breadcrumbs(): array
    {
        $crumbs = [];
        if (! $this->image->imageFolder) {
            return $crumbs;
        }
        $parent = $this->image->imageFolder;
        if ($parent->imageFolder) {
            $crumbs[] = [
                'name' => $parent->imageFolder->name,
                'open' => route('gallery.show', [$this->campaign, $parent->imageFolder]),
            ];
        }

        $crumbs[] = [
            'name' => $parent->name,
            'open' => route('gallery.show', [$this->campaign, $parent]),
        ];

        return $crumbs;
    }

    protected function visibilities(bool $withNull = false): array
    {
        $options = [];
        if ($withNull) {
            $options[] = __('');
        }

        $options[Visibility::All->value] = __('crud.visibilities.all');

        if ($this->user->isAdmin()) {
            $options[Visibility::Admin->value] = __('crud.visibilities.admin');
            $options[Visibility::Member->value] = __('crud.visibilities.members');
        }
        $options[Visibility::Self->value] = __('crud.visibilities.self');
        $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');

        return $options;
    }

    protected function space(): array
    {
        return [
            'total' => $this->storage->campaign($this->campaign)->totalSpace(),
            'used' => $this->storage->usedSpace(),
        ];
    }

    protected function upgradeLink(): ?string
    {
        if ($this->campaign->boosted()) {
            return null;
        }

        return route('settings.premium');
    }
}
