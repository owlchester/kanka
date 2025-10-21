<?php

namespace App\Http\Controllers\Whiteboards;

use App\Datagrids\Filters\WhiteboardFilter;
use App\Http\Controllers\CrudController as BaseCrudController;
use App\Http\Requests\StoreWhiteboard;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Whiteboard;

class CrudController extends BaseCrudController
{
    protected string $view = 'whiteboards';

    protected string $route = 'whiteboards';

    protected string $model = Whiteboard::class;

    protected string $filter = WhiteboardFilter::class;

    protected string $module = 'whiteboards';

    public function create(Campaign $campaign)
    {
        // @phpstan-ignore-next-line
        $this->authorize('create', [$this->getEntityType(), $campaign]);

        if (! auth()->user()->can('whiteboards', $campaign)) {
            // @phpstan-ignore-next-line
            return view('whiteboards.cta')
                ->with('campaign', $campaign);
        }

        return $this->campaign($campaign)->crudCreate();
    }

    public function store(StoreWhiteboard $request, Campaign $campaign)
    {
        // @phpstan-ignore-next-line
        $this->authorize('create', [$this->getEntityType(), $campaign]);

        if (! auth()->user()->can('whiteboards', $campaign)) {
            return view('whiteboards.cta')
                ->with('campaign', $campaign);
        }

        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Whiteboard $whiteboard)
    {
        return $this->campaign($campaign)->crudShow($whiteboard);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Whiteboard $whiteboard)
    {
        return $this->campaign($campaign)->crudEdit($whiteboard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreWhiteboard $request, Campaign $campaign, Whiteboard $whiteboard)
    {
        return $this->campaign($campaign)->crudUpdate($request, $whiteboard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Whiteboard $whiteboard)
    {
        return $this->campaign($campaign)->crudDestroy($whiteboard);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.whiteboard'))->first();
    }
}
