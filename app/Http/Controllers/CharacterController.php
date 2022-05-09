<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CharacterFilter;
use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Services\RandomCharacterService;

class CharacterController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'characters';
    protected $route = 'characters';
    protected $module = 'characters';

    /**
     * @var string
     */
    protected $model = \App\Models\Character::class;

    /**
     * @var string
     */
    protected $filter = CharacterFilter::class;

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
            'label' => '<i class="ra ra-perspective-dice-random"></i> <span class="hidden-xs hidden-sm">' . __('characters.index.actions.random') . '</span>',
            'route' => route('characters.random'),
            'class' => 'default create-random-character',
            'policy' => 'random'
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
