<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;
use App\Models\Family;
use App\Models\Organisation;
use App\Models\Race;

class CharacterFilter extends DatagridFilter
{
    /**
     * Filters available for characters
     */
    public function build()
    {
        $orgName = Module::singular(config('entities.ids.organisation'));
        $orgPlaceholder = __('crud.placeholders.organisation');
        if (!empty($orgName)) {
            $orgPlaceholder = __('crud.placeholders.fallback', ['module' => $orgName]);
        }
        $famName = Module::singular(config('entities.ids.family'));
        $famPlaceholder = __('crud.placeholders.family');
        if (!empty($famName)) {
            $famPlaceholder = __('crud.placeholders.fallback', ['module' => $famName]);
        }
        $raceName = Module::singular(config('entities.ids.race'));
        $racePlaceholder = __('crud.placeholders.race');
        if (!empty($raceName)) {
            $racePlaceholder = __('crud.placeholders.fallback', ['module' => $raceName]);
        }

        $this
            ->add('name')
            ->add('title')
            ->add([
                'field' => 'family_id',
                'label' => Module::singular(config('entities.ids.family'), __('entities.family')),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.family')]),
                'placeholder' =>  $famPlaceholder,
                'model' => Family::class,
                'withChildren' => true,
            ])
            ->location()
            ->add([
                'field' => 'race_id',
                'label' => Module::singular(config('entities.ids.race'), __('entities.race')),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.race')]),
                'placeholder' =>  $racePlaceholder,
                'model' => Race::class,
                'withChildren' => true,
            ])
            ->add([
                'field' => 'member_id',
                'label' => Module::singular(config('entities.ids.organisation'), __('entities.organisation')),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.organisation')]),
                'placeholder' => $orgPlaceholder,
                'model' => Organisation::class,
                'withChildren' => true,

            ])
            ->add('type')
            ->add('age')
            ->add('sex')
            ->add('pronouns')
            ->add('is_dead')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections()
        ;
    }
}
