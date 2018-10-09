<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Models\Family;
use App\Models\Location;
use App\Models\Race;
use App\Services\RandomCharacterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'characters';
    protected $route = 'characters';

    /**
     * @var string
     */
    protected $model = \App\Models\Character::class;

    /**
     * @var RandomCharacterService
     */
    protected $random;

    /**
     * CharacterController constructor.
     * @param RandomCharacterService $random
     */
    public function __construct(RandomCharacterService $random)
    {
        $this->random = $random;

        $this->indexActions[] = [
            'label' => '<i class="fa fa-question"></i> ' . trans('characters.index.actions.random'),
            'route' => route('characters.random'),
            'class' => 'default',
            'policy' => 'random'
        ];

        $this->filters = [
            'name',
            'title',
            [
                'field' => 'family_id',
                'label' => trans('characters.fields.family'),
                'type' => 'select2',
                'route' => route('families.find'),
                'placeholder' =>  trans('crud.placeholders.family'),
                'model' => Family::class,
            ],
            [
                'field' => 'location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ],
            [
                'field' => 'race_id',
                'label' => trans('characters.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  trans('crud.placeholders.race'),
                'model' => Race::class,
            ],
            'type',
            'age',
            'sex',
            'is_dead',
        ];

        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function random()
    {
        // We replace the source for the form prefill function in the view
        return $this->crudCreate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCharacter $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        return $this->crudShow($character);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        return $this->crudEdit($character);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharacter $request, Character $character)
    {
        return $this->crudUpdate($request, $character);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        return $this->crudDestroy($character);
    }
}
