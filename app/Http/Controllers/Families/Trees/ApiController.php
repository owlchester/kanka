<?php

namespace App\Http\Controllers\Families\Trees;

use App\Enums\Visibility;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CharacterFamily;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Services\Entity\StandardEntityCreationService;
use App\Services\Families\FamilyTreeService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected FamilyTreeService $service;

    public function __construct(FamilyTreeService $service)
    {
        $this->service = $service;
    }

    /**
     * Provide the family tree info as JSON.
     */
    public function index(Request $request, Campaign $campaign, Family $family): JsonResponse
    {
        $this->campaign($campaign)->authEntityView($family->entity);
        if (auth()->check()) {
            $this->service->user(auth()->user());
        }

        $preview = match ($request->query('preview_visibility')) {
            'all' => Visibility::All->value,
            'member' => Visibility::Member->value,
            default => null,
        };

        return response()->json(
            $this
                ->service
                ->campaign($campaign)
                ->family($family)
                ->previewVisibility($preview)
                ->api()
        );
    }

    /**
     * Provide the entity info as JSON.
     */
    public function entity(Campaign $campaign, Entity $entity): JsonResponse
    {
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('view', $entity);

        return response()->json(
            $this
                ->service
                ->entity($entity)
        );
    }

    /**
     * Save the new config.
     */
    public function save(Request $request, Campaign $campaign, Family $family): JsonResponse
    {
        $this->authorize('update', $family->entity);

        if (! $campaign->premium()) {
            return response()->json('You need to activate premium functions on the campaign to use this feature', 204);
        }

        $data = $request->input('data');

        return response()->json(
            $this
                ->service
                ->user($request->user())
                ->campaign($campaign)
                ->family($family)
                ->save(is_array($data) ? $data : [])
                ->api()
        );
    }

    /**
     * Promote a placeholder person in the tree to a real Character entity.
     */
    public function promoteCharacter(Request $request, Campaign $campaign, Family $family): JsonResponse
    {
        $this->authorize('update', $family->entity);

        if (! $campaign->premium()) {
            return response()->json('You need to activate premium functions on the campaign to use this feature', 204);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'add_to_family' => ['sometimes', 'boolean'],
        ]);

        $characterType = EntityType::findOrFail(config('entities.ids.character'));
        $this->authorize('create', [$characterType, $campaign]);

        $character = app(StandardEntityCreationService::class)
            ->campaign($campaign)
            ->entityType($characterType)
            ->user($request->user())
            ->create([
                'name' => trim($validated['name']),
            ]);

        if ($validated['add_to_family'] ?? true) {
            CharacterFamily::firstOrCreate([
                'character_id' => $character->id,
                'family_id' => $family->id,
            ]);
        }

        return response()->json(
            $this->service->entity($character->entity),
            201
        );
    }
}
