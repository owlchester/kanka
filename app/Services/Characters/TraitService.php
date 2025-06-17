<?php

namespace App\Services\Characters;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Traits\RequestAware;
use App\Traits\UserAware;

abstract class TraitService
{
    use UserAware;
    use RequestAware;

    protected Character $character;
    protected array $existing;

    public function model(Character $character): self
    {
        $this->character = $character;

        return $this;
    }

    public function process(): void
    {
        if (!$this->validate()) {
            return;
        }

        $this->loadExisting();

        $traitOrder = 0;
        $names = $this->request->get($this->field . '_name', []);
        $entries = $this->request->get($this->field . '_entry', []);

        foreach ($names as $id => $name) {
            if (empty($name)) {
                continue;
            }

            if (! empty($this->existing[$id])) {
                $model = $this->existing[$id];
                unset($this->existing[$id]);
            } else {
                $model = new CharacterTrait;
                $model->character_id = $this->character->id;
                $model->section_id = $this->mode;
                EntityLogger::dirty('traits', null);
            }
            $model->name = $name;
            $model->entry = $entries[$id];
            $model->default_order = $traitOrder;
            $model->save();
            $traitOrder++;
        }

        $this->removeExisting();
    }

    protected function loadExisting(): void
    {
        $this->existing = [];
        foreach ($this->character->characterTraits()->{$this->field}()->get() as $pers) {
            $this->existing[$pers->id] = $pers;
        }
    }

    protected function removeExisting(): void
    {
        foreach ($this->existing as $id => $model) {
            $model->delete();
            EntityLogger::dirty('traits', null);
        }
    }

}
