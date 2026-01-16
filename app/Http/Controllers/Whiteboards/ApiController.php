<?php

namespace App\Http\Controllers\Whiteboards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whiteboards\StoreShapeRequest;
use App\Http\Requests\Whiteboards\UpdateShapeRequest;
use App\Models\Campaign;
use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use App\Services\Whiteboards\ApiService;
use App\Services\Whiteboards\Shapes\PersistanceService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected ApiService $apiService, protected PersistanceService $persistanceService) {}

    public function index(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->campaign($campaign)->authEntityView($whiteboard->entity);
        if (auth()->check()) {
            $this->apiService->user(auth()->user());
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->whiteboard($whiteboard)
                ->load()
        );
    }

    public function store(StoreShapeRequest $request, Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('update', $whiteboard->entity);

        $shape = $this->persistanceService
            ->whiteboard($whiteboard)
            ->request($request)
            ->create();

        return response()->json([
            'success' => true,
            'id' => $shape->id,
            'urls' => [
                'edit' => route('whiteboards.shapes.update', [$campaign, $whiteboard, $shape]),
                'delete' => route('whiteboards.shapes.delete', [$campaign, $whiteboard, $shape]),
            ]
        ]);
    }

    public function update(UpdateShapeRequest $request, Campaign $campaign, Whiteboard $whiteboard, WhiteboardShape $whiteboardShape)
    {
        $this->authorize('view', $campaign);
        $this->authorize('update', $whiteboard->entity);

        $whiteboardShape->update($request->only([
            'x', 'y',
            'width', 'height',
            'scale_x', 'scale_y',
            'rotation',
            'is_locked',
            'z_index',
            'shape',
        ]));

        return response()->json([
            'success' => true,
        ]);
    }
}
