<?php

namespace App\Http\Controllers\Entity\Abilities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Abilities\ImportService;
use Exception;

class ImportController extends Controller
{
    protected ImportService $service;

    public function __construct(ImportService $chargeService)
    {
        $this->service = $chargeService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        if (! $entity->isCharacter()) {
            return redirect()->route('entities.entity_abilities.index', [$campaign, $entity])
                ->with('error', __('entities/abilities.import.errors.not_character'));
        }

        $races = [];
        foreach ($entity->child->characterRaces as $race) {
            // Exclude races with no abilities from the list.
            if ($race->race->entity->abilities->count() > 0) {
                $races[$race->race->name] = $race->race->entity->abilities->count();
            }
        }

        return view('entities.pages.abilities.import', compact(
            'campaign',
            'entity',
            'races'
        ));
    }

    public function import(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        try {
            $count = $this->service
                ->entity($entity)
                ->import();

            return redirect()->route('entities.entity_abilities.index', [$campaign, $entity])
                ->with('success', trans_choice('entities/abilities.import.success', $count, ['count' => $count]));
        } catch (Exception $e) {
            return redirect()->route('entities.entity_abilities.index', [$campaign, $entity])
                ->with('error', __('entities/abilities.import.errors.' . $e->getMessage()));
        }
    }
}
