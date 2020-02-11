<?php


namespace App\Datagrids\Filters;


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
}
