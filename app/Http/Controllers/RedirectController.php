<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\EntityService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    private EntityService $entity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');

        $this->entity = $entityService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, Campaign $campaign)
    {
        $mapper = [
            'character' => 'characters',
            'family' => 'families',
            'item' => 'items',
            'journal' => 'journals',
            'location' => 'locations',
            'note' => 'notes',
            'organisation' => 'organisations',
            'event' => 'events',
            'quest' => 'quests',
        ];

        $allowed = $this->entity->entities();

        $what = $request->get('what');
        // Fix some common mistakes
        if (in_array($what, array_keys($mapper))) {
            $what = $mapper[$what];
        }
        $name = $request->get('name');

        if (! in_array($what, array_keys($allowed))) {
            return redirect()->route('home')->withErrors(trans('redirects.unknown_entity', ['entity' => e($what)]));
        }

        $modelClass = new $allowed[$what];
        $model = $modelClass->where('name', 'like', "%{$name}%")->first();
        if ($model) {
            return redirect()->route($what . '.show', [$campaign, $model]);
        }

        return redirect()->route($what . '.create', [$campaign, 'name' => $name]);
    }
}
