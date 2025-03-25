<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\TagFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreTag;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Tag;

class TagController extends CrudController
{
    protected string $view = 'tags';

    protected string $route = 'tags';

    protected string $module = 'tags';

    protected string $model = Tag::class;

    protected string $filter = TagFilter::class;

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

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.tag'))->first();
    }
}
