<?php


namespace App\Datagrids\Filters;


use App\Models\Character;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

abstract class DatagridFilter
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Get the filters
     * @return array
     */
    public function filters(): array
    {
        return $this->filters;
    }

    /**
     * @param string|array $name
     * @return $this
     */
    protected function add($name): self
    {
        $this->filters[] = $name;
        return $this;
    }

    /**
     * Add the location filters
     * @return $this
     */
    protected function location(): self
    {
        $this->filters[] = [
            'field' => 'location_id',
            'label' => trans('crud.fields.location'),
            'type' => 'select2',
            'route' => route('locations.find'),
            'placeholder' =>  trans('crud.placeholders.location'),
            'model' => Location::class,
        ];
        return $this;
    }

    /**
     * Add the character filters
     * @return $this
     */
    protected function character(): self
    {
        $this->filters[] = [
            'field' => 'character_id',
            'label' => trans('crud.fields.character'),
            'type' => 'select2',
            'route' => route('characters.find'),
            'placeholder' =>  trans('crud.placeholders.character'),
            'model' => Character::class,
        ];
        return $this;
    }

    /**
     * Add the character filters
     * @return $this
     */
    protected function journal(): self
    {
        $this->filters[] = [
            'field' => 'journal_id',
            'label' => trans('journals.fields.journal'),
            'type' => 'select2',
            'route' => route('journals.find'),
            'placeholder' =>  trans('crud.placeholders.journal'),
            'model' => Journal::class,
        ];
        return $this;
    }

    /**
     * Add the tags filters
     * @return $this
     */
    protected function tags(): self
    {
        $this->filters[] = [
            'field' => 'tags',
            'label' => trans('crud.fields.tag'),
            'type' => 'tag',
            'route' => route('tags.find'),
            'placeholder' =>  trans('crud.placeholders.tag'),
            'model' => Tag::class,
        ];
        return $this;
    }

    /**
     * Add the is_private
     * @return $this
     */
    protected function isPrivate(): self
    {
        // Add the is_private filter only for admins.
        if (Auth::check() && Auth::user()->isAdmin()) {
            $this->filters[] = 'is_private';
        }

        return $this;
    }

    /**
     * Add the has image
     * @return $this
     */
    protected function hasImage(): self
    {
        $this->filters[] = 'has_image';
        return $this;
    }

    /**
     * Add the (real) date filter
     * @return $this
     */
    protected function date(): self
    {
        $this->filters[] = 'date';
        return $this;
    }
}
