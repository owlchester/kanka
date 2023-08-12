<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\TagFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreTag;
use App\Models\Campaign;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;

class TagController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'tags';
    protected string $route = 'tags';
    protected $module = 'tags';

    /** @var string Model */
    protected $model = \App\Models\Tag::class;

    /** @var string Filter */
    protected $filter = TagFilter::class;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasLimitCheck(false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTag $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Tag $tag)
    {
        return $this->campaign($campaign)->crudShow($tag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Tag $tag)
    {
        return $this->campaign($campaign)->crudEdit($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTag $request, Campaign $campaign, Tag $tag)
    {
        return $this->campaign($campaign)->crudUpdate($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Tag $tag)
    {
        return $this->campaign($campaign)->crudDestroy($tag);
    }
}
