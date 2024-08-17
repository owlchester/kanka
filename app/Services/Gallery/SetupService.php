<?php

namespace App\Services\Gallery;

use App\Enums\Visibility;
use App\Facades\Limit;
use App\Http\Resources\GalleryFile;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
use App\Models\Image;

class SetupService
{
    use CampaignAware;
    use UserAware;

    protected Collection $files;
    protected Image $image;
    protected ?String $term;
    protected ?string $nextPage;

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

    public function setup(): array
    {
        return [
            'acl' => [
                'manage' => $this->user->can('galleryManage', $this->campaign),
                'upload' => $this->user->can('galleryUpload', $this->campaign),
            ],
            'files' => $this->files(),
            'i18n' => $this->i18n(),
            'search' => route('gallery.search', [$this->campaign]),
            'delete' => route('gallery.delete', [$this->campaign]),
            'create' => route('gallery.create', [$this->campaign]),
            'upload' => route('gallery.upload.files', [$this->campaign]),
            'next' => $this->nextPage ?? null,
            'visibilities' => $this->visibilities()
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
        $this->files = new Collection();
        $query = $this
            ->campaign
            ->images()
            ->with(['images', 'creator'])
            ->defaultOrder();
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
            $this->nextPage = $files->nextPageUrl();
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
            'move' => __('crud.actions.move'),
            'home' => __('Home'),
            'load_more' => __('Load more'),
            'upload_hint' => __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, woff2', 'size' => Limit::readable()->upload()])
        ];
    }

    protected function breadcrumbs(): array
    {
        $crumbs = [];
        if (!$this->image->imageFolder) {
            return $crumbs;
        }
        $parent = $this->image->imageFolder;
        $crumbs[] = [
            'name' => $parent->name,
            'open' => route('gallery.show', [$this->campaign, $parent]),
        ];

        return $crumbs;
    }

    protected function visibilities(): array
    {
        $options[Visibility::All->value] = __('crud.visibilities.all');

        if ($this->user->isAdmin()) {
            $options[Visibility::Admin->value] = __('crud.visibilities.admin');
            $options[Visibility::Member->value] = __('crud.visibilities.members');
        }
        $options[Visibility::Self->value] = __('crud.visibilities.self');
        $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');

        return $options;
    }
}
