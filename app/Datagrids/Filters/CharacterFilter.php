<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;

class CharacterFilter extends DatagridFilter
{
    /**
     * Filters available for characters
     */
    public function build()
    {
        $orgName = Module::singular(config('entities.ids.organisation'));
        $orgPlaceholder = __('crud.placeholders.organisation');
        if (! empty($orgName)) {
            $orgPlaceholder = __('crud.placeholders.fallback', ['module' => $orgName]);
        }
        $famName = Module::singular(config('entities.ids.family'));
        $famPlaceholder = __('crud.placeholders.family');
        if (! empty($famName)) {
            $famPlaceholder = __('crud.placeholders.fallback', ['module' => $famName]);
        }
        $raceName = Module::singular(config('entities.ids.race'));
        $racePlaceholder = __('crud.placeholders.race');
        if (! empty($raceName)) {
            $racePlaceholder = __('crud.placeholders.fallback', ['module' => $raceName]);
        }

        $this
            ->add('name')
            ->add('title')
            ->families()
            ->locations()
            ->races()
            ->organisations()
            ->add('type')
            ->add('age')
            ->add('sex')
            ->add('pronouns')
            ->add('is_dead')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntry()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
