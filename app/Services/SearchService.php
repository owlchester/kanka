<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;

class SearchService
{
    /**
     * The search term
     * @var string
     */
    protected $term;

    /**
     * The search entity type
     * @var string
     */
    protected $type;

    /**
     * The campaign
     * @var Campaign
     */
    protected $campaign;

    /**
     * Amount of results (sql limit)
     * @var int
     */
    protected $limit = 10;

    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * List of excluded entity types
     * @var array
     */
    protected $excludedTypes = [];

    /**
     * List of the only entity types desired
     * @var array
     */
    protected $onlyTypes = [];

    /**
     * Set to true for a full result (rather than id => name)
     * @var bool
     */
    protected $full = false;

    /**
     * SearchService constructor.
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * The search term as requested by the user
     * @param $term
     * @return $this
     */
    public function term($term)
    {
        $this->term = $term;
        return $this;
    }

    /**
     * The search entity type as requested by the user
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        if (!empty($type)) {
            $this->onlyTypes = [$type];
        }
        return $this;
    }

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit = 10)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param $types
     * @return $this
     */
    public function exclude($types)
    {
        $this->excludedTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
     * @param $types
     * @return $this
     */
    public function only($types)
    {
        $this->onlyTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
     * Set the result as full (live search, mentions)
     * @return $this
     */
    public function full()
    {
        $this->full = true;
        return $this;
    }

    /**
     * List of entities matching the request
     * @return array
     */
    public function find()
    {
        // Figure out what kind of entities we want.
        $availableEntityTypes = $this->entityService->getEnabledEntities($this->campaign);

        // If a list of types are provided, use those
        if (!empty($this->onlyTypes)) {
            $availableEntityTypes = $this->onlyTypes;
        }

        $query = Entity::whereIn('type', $availableEntityTypes);
        if (empty($this->term)) {
            $query->orderBy('updated_at', 'DESC');
        } else {
            $query->where('name', 'like', '%' . $this->term . '%');
        }


        $query
            ->acl()
            ->limit($this->limit);

        $searchResults = [];
        foreach ($query->get() as $model) {
            // Force having a child for "ghost" entities.
            if ($model->child) {
                $img = '';
                if (!empty($model->child->image)) {
                    $img = '<span class="entity-image-mention" style="background-image: url(\''
                        . $model->child->getImageUrl(true) . '\');"></span> ';
                }

                if ($this->full) {
                    $searchResults[] = [
                        'id' => $model->id,
                        'fullname' => e($model->name),
                        'image' => $img,
                        'name' => e($model->name),
                        'type' => __('entities.' . $model->type),
                        'tooltip' => $model->tooltip(),
                        'url' => $model->url()
                    ];
                } else {
                    $searchResults[] = [
                        'id' => $model->id,
                        'text' => e($model->name) . ' (' . trans('entities.' . $model->type) . ')'
                    ];
                }
            }
        }

        return $searchResults;
    }

    /**
     * List of months in the calendars
     * @return array
     */
    public function monthList()
    {
        $searchResults = [];

        // Load up the calendars of a campaign to get the month names
        $calendars = Calendar::acl()->get();
        foreach ($calendars as $calendar) {
            $months = $calendar->months();

            foreach ($months as $month) {
                if ((!empty($this->term) && strpos($month['name'], $this->term) !== false) || empty($this->term)) {
                    $searchResults[] = [
                        'fullname' => $month['name'],
                        'name' => $month['name'] . ' (' . $calendar->name . ')',
                    ];
                }
            }
        }

        return $searchResults;
    }
}
