<?php

namespace App\Datagrids\Filters;

use App\Models\Character;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

/**
 * This abstract class sets up all the stuff needed for rendering filters on entity datagrids.
 * Each entity has a class that extends this class and in the constructor sets the fields available.
 * Filters that are re-used multiple times or have their own rendering logic are added as functions
 * directly on this class.
 */
abstract class DatagridFilter
{
    /** @var array Filters to be rendered */
    protected array $filters = [];

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
            'label' => __('crud.fields.location'),
            'type' => 'select2',
            'route' => route('locations.find'),
            'placeholder' =>  __('crud.placeholders.location'),
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
            'label' => __('crud.fields.character'),
            'type' => 'select2',
            'route' => route('characters.find'),
            'placeholder' =>  __('crud.placeholders.character'),
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
            'label' => __('journals.fields.journal'),
            'type' => 'select2',
            'route' => route('journals.find'),
            'placeholder' =>  __('crud.placeholders.journal'),
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
            'label' => __('crud.fields.tag'),
            'type' => 'tag',
            'route' => route('tags.find'),
            'placeholder' =>  __('crud.placeholders.tag'),
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
     * Add the entity has an image
     * @return $this
     */
    protected function hasImage(): self
    {
        $this->filters[] = 'has_image';
        return $this;
    }

    /**
     * Add the entity has posts
     * @return $this
     */
    protected function hasEntityNotes(): self
    {
        $this->filters[] = 'has_entity_notes';
        return $this;
    }

    /**
     * Add the entity has attributes
     * @return $this
     */
    protected function hasAttributes(): self
    {
        $this->filters[] = 'has_attributes';
        return $this;
    }

    /**
     * Add the has image
     * @return $this
     */
    protected function hasEntityFiles(): self
    {
        $this->filters[] = 'has_entity_files';
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

    /**
     * Add the attributes selector
     * @return $this
     */
    protected function attributes(): self
    {
        $this->filters[] = 'attributes';
        return $this;
    }

    /**
     * Add the date range filter
     * @return $this
     */
    protected function dateRange(): self
    {
        $this->filters[] = 'date_range';
        return $this;
    }
}
