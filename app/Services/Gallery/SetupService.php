<?php

namespace App\Services\Gallery;

use App\Enums\Visibility;
use App\Facades\Limit;
use App\Http\Resources\GalleryFile;
use App\Models\Image;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SetupService
{
    use CampaignAware;
    use UserAware;

    protected Collection $files;

    protected ?Image $image = null;

    protected ?string $term = null;

    protected ?string $nextPage = null;

    protected array $pagination = [];

    protected array $filters = [];

    protected array $sort = [];

    protected StorageService $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function image(?Image $image): self
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
                'premium' => $this->campaign->boosted() || $this->storage->campaign($this->campaign)->isUnlimited(),
                'elemental' => $this->campaign->isElemental(),
                'wyvern' => $this->campaign->isWyvern(),
                'user_id' => $this->user->id,
            ],
            'files' => $this->files(),
            'pagination' => $this->pagination,
            'i18n' => $this->i18n(),
            'folders' => $this->folders(),
            'folder_tree' => $this->folderTree(),
            'uploaders' => $this->uploaders(),
            'api' => [
                'items' => route('gallery.items', [$this->campaign]),
                'search' => route('gallery.search', [$this->campaign]),
                'delete' => route('gallery.delete', [$this->campaign]),
                'deletePreview' => route('gallery.delete-preview', [$this->campaign]),
                'create' => route('gallery.create', [$this->campaign]),
                'update' => route('gallery.update', [$this->campaign]),
                'upload' => route('gallery.upload.files', [$this->campaign]),
                'uploadUrl' => route('gallery.upload.url', [$this->campaign]),
            ],
            'next' => $this->nextPage,
            'visibilities' => $this->visibilities(),
            'bulkVisibilities' => $this->visibilities(true),
            'url' => route('gallery', $this->campaign),
            'space' => $this->space(),
            'upgrade' => $this->upgradeLink(),
        ];
    }

    /**
     * Unified paginated listing for the gallery UI.
     */
    public function items(): array
    {
        $files = $this->files();

        $selectedImage = null;
        $selectedImageId = Arr::get($this->filters, 'image');
        if (! empty($selectedImageId) && is_string($selectedImageId)) {
            $found = Image::where('campaign_id', $this->campaign->id)
                ->where('id', $selectedImageId)
                ->with(['creator'])
                ->withCount(['entities', 'headers', 'mentions', 'entityAssets', 'mapLayers', 'inventories', 'images'])
                ->first();

            if ($found && $this->user->can('view', [$found, $this->campaign])) {
                $selectedImage = (new GalleryFile($found))->campaign($this->campaign);
            }
        }

        return [
            'folder' => $this->image
                ? (new GalleryFile($this->image))->campaign($this->campaign)
                : null,
            'breadcrumbs' => $this->image ? $this->breadcrumbs() : [],
            'files' => $files,
            'pagination' => $this->pagination,
            'next' => $this->nextPage,
            'selected_image' => $selectedImage,
        ];
    }

    /**
     * Open a folder (legacy endpoint preserved for backwards compatibility).
     */
    public function open(): array
    {
        return [
            'folder' => $this->image,
            'files' => $this->files(),
            'breadcrumbs' => $this->breadcrumbs(),
            'pagination' => $this->pagination,
            'next' => $this->nextPage,
            'url' => route('gallery', [$this->campaign, 'folder' => $this->image?->id]),
        ];
    }

    public function search(): array
    {
        return [
            'files' => $this->files(),
            'pagination' => $this->pagination,
            'next' => $this->nextPage,
        ];
    }

    protected function files(): array
    {
        $this->files = new Collection;
        $canBrowse = $this->user->can('galleryBrowse', $this->campaign);

        $query = Image::where('campaign_id', $this->campaign->id)
            ->acl($canBrowse)
            ->with(['creator'])
            ->withCount(['entities', 'headers', 'mentions', 'entityAssets', 'mapLayers', 'inventories', 'images']);

        $this->applySorting($query);
        $this->applyFilters($query);

        $perPage = (int) Arr::get($this->filters, 'per_page', 24);
        if (! in_array($perPage, [24, 48, 96], true)) {
            $perPage = 24;
        }

        $files = $query->paginate($perPage);

        // Fetch up to 3 thumbnail previews per folder on the current page in one query (no N+1)
        $folderIds = collect($files->items())
            ->filter(fn (Image $item) => $item->isFolder())
            ->pluck('id')
            ->all();
        $folderThumbnails = $this->fetchFolderThumbnails($folderIds, $canBrowse);

        /** @var Image $file */
        foreach ($files as $file) {
            $resource = (new GalleryFile($file))->campaign($this->campaign);
            if ($file->isFolder()) {
                $resource->withThumbnails($folderThumbnails[$file->id] ?? []);
            }
            $this->files->add($resource);
        }

        $this->pagination = [
            'current_page' => $files->currentPage(),
            'last_page' => $files->lastPage(),
            'per_page' => $files->perPage(),
            'total' => $files->total(),
            'from' => $files->firstItem() ?? 0,
            'to' => $files->lastItem() ?? 0,
        ];

        $this->nextPage = $files->hasMorePages()
            ? $files->appends(array_filter($this->filters))->nextPageUrl()
            : null;

        return $this->files->toArray();
    }

    /**
     * @param  Builder<Image>  $query
     */
    protected function applySorting(Builder $query): void
    {
        $sort = Arr::get($this->sort, 'sort', 'recent');

        // Keep folders grouped first
        $query->orderBy('is_folder', 'desc');

        match ($sort) {
            'asc', 'name_asc' => $query->orderBy('name', 'asc')->orderBy('updated_at', 'desc'),
            'desc', 'name_desc' => $query->orderBy('name', 'desc')->orderBy('updated_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc')->orderBy('name', 'asc'),
            'updated_asc' => $query->orderBy('updated_at', 'asc')->orderBy('name', 'asc'),
            'size_desc' => $query->orderBy('size', 'desc')->orderBy('name', 'asc'),
            'size_asc' => $query->orderBy('size', 'asc')->orderBy('name', 'asc'),
            'used_desc' => $query->orderByRaw($this->usageCountSql() . ' DESC')->orderBy('name', 'asc'),
            'used_asc' => $query->orderByRaw($this->usageCountSql() . ' ASC')->orderBy('name', 'asc'),
            default => $query->orderBy('updated_at', 'desc')->orderBy('name', 'asc'),
        };
    }

    protected function usageCountSql(): string
    {
        return '(
            (SELECT COUNT(*) FROM entities WHERE entities.image_uuid = images.id)
            + (SELECT COUNT(*) FROM entities WHERE entities.header_uuid = images.id)
            + (SELECT COUNT(*) FROM image_mentions WHERE image_mentions.image_id = images.id)
            + (SELECT COUNT(*) FROM entity_assets WHERE entity_assets.image_uuid = images.id)
            + (SELECT COUNT(*) FROM map_layers WHERE map_layers.image_uuid = images.id)
            + (SELECT COUNT(*) FROM inventories WHERE inventories.image_uuid = images.id)
            + (CASE WHEN images.is_default = 1 THEN 1 ELSE 0 END)
        )';
    }

    /**
     * @param  Builder<Image>  $query
     */
    protected function applyFilters(Builder $query): void
    {
        $usage = Arr::get($this->filters, 'usage');
        if ($usage === 'unused' || Arr::get($this->filters, 'unused')) {
            $query->notUsed();
        } elseif ($usage === 'used') {
            $query->used();
        }

        $type = Arr::get($this->filters, 'type');
        if (! empty($type) && $type !== 'all') {
            $query->ofType($type);
        }

        $visibilityId = Arr::get($this->filters, 'visibility_id');
        if ($visibilityId !== null && $visibilityId !== '' && $visibilityId !== 'all') {
            $query->where('images.visibility_id', (int) $visibilityId);
        }

        $createdBy = Arr::get($this->filters, 'created_by');
        if ($createdBy !== null && $createdBy !== '' && $createdBy !== 'all') {
            $query->where('images.created_by', (int) $createdBy);
        }

        $orientation = Arr::get($this->filters, 'orientation');
        if (! empty($orientation) && $orientation !== 'all') {
            $query->orientation($orientation);
        }

        $scope = Arr::get($this->filters, 'scope', 'all');
        $hasSearch = ! empty($this->term);
        $hasGlobalFilter = $usage === 'unused' || $usage === 'used'
            || Arr::get($this->filters, 'unused')
            || (! empty($type) && $type !== 'all')
            || (! empty($orientation) && $orientation !== 'all');

        if ($hasSearch) {
            $query->searchMetadata($this->term);
            if ($scope === 'folder') {
                $query->imageFolder($this->image?->id);
            }
        } elseif (! $hasGlobalFilter || $scope === 'folder' || $this->image !== null) {
            if (! ($hasGlobalFilter && $scope === 'all' && $this->image === null)) {
                $query->imageFolder($this->image?->id);
            }
        }
    }

    /**
     * Fetch up to 3 raster thumbnail URLs per folder ID in a single query.
     *
     * @param  array<int, string>  $folderIds
     * @return array<string, array<int, string>>
     */
    protected function fetchFolderThumbnails(array $folderIds, bool $canBrowse): array
    {
        if (empty($folderIds)) {
            return [];
        }

        $children = Image::where('campaign_id', $this->campaign->id)
            ->acl($canBrowse)
            ->whereIn('folder_id', $folderIds)
            ->where('is_folder', false)
            ->whereIn('ext', ['jpg', 'png', 'jpeg', 'gif', 'webp'])
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'campaign_id', 'folder_id', 'ext', 'version', 'focus_x', 'focus_y']);

        $grouped = [];
        foreach ($children as $child) {
            $fid = (string) $child->folder_id;
            if (! isset($grouped[$fid])) {
                $grouped[$fid] = [];
            }
            if (count($grouped[$fid]) >= 3) {
                continue;
            }
            $grouped[$fid][] = $child->getUrl(192, 144);
        }

        return $grouped;
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
            'upload_hint' => empty(config('limits.filesize.image.standard'))
                ? __('crud.hints.image_formats', ['formats' => 'jpg, png, webp, gif, svg, woff2'])
                : __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, svg, woff2', 'size' => Limit::readable()->upload()]),

            // Space
            'storage' => __('campaigns/gallery.storage.title'),
            'of' => __('campaigns/gallery.storage.of'),
            'upgrade' => __('campaigns/gallery.actions.upgrade'),

            // Files
            'details' => __('campaigns/gallery.fields.details'),
            'used_in' => __('campaigns/gallery.fields.used_in'),
            'unused' => __('campaigns/gallery.fields.unused'),
            'name' => __('crud.fields.name'),
            'description' => __('campaigns/gallery.fields.description'),
            'author' => __('campaigns/gallery.fields.author'),
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

            // Filters & Sorting
            'filter_only_unused' => __('gallery.filters.only_unused'),
            'sort' => __('gallery.filters.sort'),
            'sort_asc' => __('crud.filters.sorting.asc', ['field' => 'Name']),
            'sort_desc' => __('crud.filters.sorting.desc', ['field' => 'Name']),
            'sort_default' => __('gallery.sort.updated_desc'),
            'sort_updated_asc' => __('gallery.sort.updated_asc'),
            'sort_oldest' => __('gallery.sort.oldest'),
            'sort_size_desc' => __('gallery.sort.size_desc'),
            'sort_size_asc' => __('gallery.sort.size_asc'),
            'sort_used_desc' => __('gallery.sort.used_desc'),
            'sort_used_asc' => __('gallery.sort.used_asc'),

            // Visibilities
            'visibility.1' => __('crud.visibilities.all'),
            'visibility.2' => __('crud.visibilities.admin'),
            'visibility.3' => __('crud.visibilities.admin-self'),
            'visibility.4' => __('crud.visibilities.self'),
            'visibility.5' => __('crud.visibilities.members'),

            // Overhaul UI keys
            'views_grid' => __('gallery.views.grid'),
            'views_compact' => __('gallery.views.compact'),
            'views_table' => __('gallery.views.table'),
            'search_placeholder' => __('gallery.search.placeholder'),
            'scope_folder' => __('gallery.search.scope_folder'),
            'scope_all' => __('gallery.search.scope_all'),
            'usage_label' => __('gallery.filters.usage'),
            'usage_all' => __('gallery.filters.usage_all'),
            'usage_unused' => __('gallery.filters.usage_unused'),
            'usage_used' => __('gallery.filters.usage_used'),
            'type_label' => __('gallery.filters.type'),
            'type_all' => __('gallery.filters.type_all'),
            'type_image' => __('gallery.filters.type_image'),
            'type_svg' => __('gallery.filters.type_svg'),
            'type_font' => __('gallery.filters.type_font'),
            'orientation_label' => __('gallery.filters.orientation'),
            'orientation_all' => __('gallery.filters.orientation_all'),
            'orientation_landscape' => __('gallery.filters.orientation_landscape'),
            'orientation_portrait' => __('gallery.filters.orientation_portrait'),
            'orientation_square' => __('gallery.filters.orientation_square'),
            'uploader_label' => __('gallery.filters.uploader'),
            'all' => __('gallery.filters.all'),
            'reset_filters' => __('gallery.filters.reset'),
            'cleanup_unused' => __('gallery.storage.cleanup_unused'),
            'upload_files' => __('gallery.upload.files'),
            'upload_url' => __('gallery.actions.add_url'),
            'upload_url_title' => __('gallery.actions.url'),
            'upload_url_hint' => __('gallery.actions.url_hint'),
            'drop_to_upload' => __('gallery.drop.overlay'),
            'copy_url' => __('gallery.actions.copy_url'),
            'copy_admin_link' => __('gallery.actions.copy_admin_link'),
            'copied' => __('gallery.actions.copied'),
            'download' => __('gallery.actions.download'),
            'replace_file' => __('gallery.replace.button'),
            'replace_hint' => __('gallery.replace.hint'),
            'dimensions' => __('gallery.fields.dimensions'),
            'updated_at' => __('gallery.fields.updated_at'),
            'select_all' => __('gallery.bulk.select_all'),
            'selected_count' => __('gallery.bulk.selected_count'),
            'clear' => __('gallery.bulk.clear'),
            'move_to' => __('gallery.bulk.move_to'),
            'delete_permanently' => __('gallery.delete_modal.confirm_button'),
            'delete_title' => __('gallery.delete_modal.title'),
            'delete_entry_warning' => __('gallery.delete_modal.entry_warning'),
            'delete_asset_warning' => __('gallery.delete_modal.asset_warning'),
            'delete_folder_warning' => __('gallery.delete_modal.folder_warning'),
            'delete_unused_note' => __('gallery.delete_modal.unused_note'),
            'checking_usage' => __('gallery.delete_modal.checking'),
            'usage_entity_images' => __('gallery.usage.entity_images'),
            'usage_entity_headers' => __('gallery.usage.entity_headers'),
            'usage_entry_mentions' => __('gallery.usage.entry_mentions'),
            'usage_entry_mentions_note' => __('gallery.usage.entry_mentions_note'),
            'usage_map_layers' => __('gallery.usage.map_layers'),
            'usage_entity_assets' => __('gallery.usage.entity_assets'),
            'usage_inventories' => __('gallery.usage.inventories'),
            'usage_default' => __('gallery.usage.default'),
            'focus_description' => __('gallery.focus.description'),
            'focus_preview_avatar' => __('gallery.focus.preview_avatar'),
            'focus_preview_card' => __('gallery.focus.preview_card'),
            'focus_preview_header' => __('gallery.focus.preview_header'),
            'focus_reset' => __('campaigns/gallery.actions.reset_focus'),
            'font_copy_css' => __('gallery.font.copy_css'),
            'font_sample' => __('gallery.font.sample'),
            'folders_title' => __('gallery.folders.title'),
            'empty_title' => __('gallery.empty.title'),
            'empty_filtered' => __('gallery.empty.filtered'),
            'per_page' => __('gallery.pagination.per_page'),
            'showing' => __('gallery.pagination.showing'),
            'previous' => __('gallery.pagination.previous'),
            'next' => __('gallery.pagination.next'),
        ];
    }

    protected function folders(): array
    {
        $folders = [
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

    /**
     * Full folder tree for the sidebar and move dialogs.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function folderTree(): array
    {
        $canBrowse = $this->user->can('galleryBrowse', $this->campaign);

        return $this->campaign
            ->images()
            ->acl($canBrowse)
            ->where('is_folder', true)
            ->withCount('images')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'folder_id'])
            ->map(fn (Image $f) => [
                'id' => $f->id,
                'name' => $f->name,
                'folder_id' => $f->folder_id,
                'items_count' => (int) $f->images_count,
            ])
            ->values()
            ->all();
    }

    /**
     * Distinct campaign uploaders for the uploader filter dropdown.
     *
     * @return array<int, array{id: int, name: string}>
     */
    protected function uploaders(): array
    {
        $creatorIds = $this->campaign
            ->images()
            ->whereNotNull('created_by')
            ->distinct()
            ->pluck('created_by');

        if ($creatorIds->isEmpty()) {
            return [];
        }

        return User::whereIn('id', $creatorIds)
            ->orderBy('name', 'asc')
            ->get(['id', 'name'])
            ->map(fn ($u) => ['id' => $u->id, 'name' => $u->name])
            ->values()
            ->all();
    }

    protected function breadcrumbs(): array
    {
        if (! $this->image) {
            return [];
        }

        $crumbs = [];
        $visited = [$this->image->id => true];
        $current = $this->image->imageFolder;
        $depth = 0;

        while ($current && $depth < 50) {
            if (isset($visited[$current->id])) {
                break;
            }
            $visited[$current->id] = true;
            array_unshift($crumbs, [
                'id' => $current->id,
                'name' => $current->name,
                'open' => route('gallery.show', [$this->campaign, $current]),
            ]);
            $current = $current->imageFolder;
            $depth++;
        }

        return $crumbs;
    }

    protected function visibilities(bool $withNull = false): array
    {
        $options = [];
        if ($withNull) {
            $options[] = __('');
        }

        $options[Visibility::All->value] = __('crud.visibilities.all');

        if ($this->user->can('admin', $this->campaign)) {
            $options[Visibility::Admin->value] = __('crud.visibilities.admin');
            $options[Visibility::Member->value] = __('crud.visibilities.members');
        }
        $options[Visibility::Self->value] = __('crud.visibilities.self');
        $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');

        return $options;
    }

    protected function space(): array
    {
        $storage = $this->storage->campaign($this->campaign);

        return [
            'total' => $storage->isUnlimited() ? 0 : $storage->totalSpace(),
            'used' => $storage->usedSpace(),
        ];
    }

    protected function upgradeLink(): ?string
    {
        if ($this->campaign->isElemental() || $this->campaign->isWyvern()) {
            return null;
        } elseif ($this->campaign->boosted()) {
            return route('settings.subscription');
        }

        return route('settings.premium');
    }
}
