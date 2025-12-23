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
            ->archived()
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
