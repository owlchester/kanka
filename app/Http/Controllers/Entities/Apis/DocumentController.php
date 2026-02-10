<?php

namespace App\Http\Controllers\Entities\Apis;

use App\Facades\Avatar;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;

class DocumentController extends Controller
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity);

        return response()->json([
            'document' => $entity->entry,
            'mentions' => $this->mentions($entity),
        ]);
    }

    protected function mentions(Entity $entity): array
    {
        // @phpstan-ignore-next-line
        return $entity->mentions()->with(['entity', 'entity.entityType', 'entity.aliases'])->get()->map(function ($mention) {
            if ($mention->isEntity()) {
                return [
                    'id' => $mention->target_id,
                    'name' => $mention->target->name,
                    'type' => $mention->target->entityType->code,
                    'image' => Avatar::entity($mention->target)->fallback()->size(32)->thumbnail(),
                    'url' => $mention->target->url(),
                    'aliases' => $mention->target->aliases->map(fn ($alias) => [
                        'id' => $alias->id,
                        'name' => $alias->name,
                    ])->toArray(),
                ];
            }

            return [
                'id' => $mention->id,
                // @phpstan-ignore-next-line
                'label' => $mention->label,
                // @phpstan-ignore-next-line
                'mention' => $mention->mention,
            ];
        })->toArray();
    }
}
