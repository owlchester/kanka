<?php

namespace App\Services\Models;

use App\Models\Bookmark;
use App\Models\Character;
use App\Models\MiscModel;
use App\Services\AttributeService;
use App\Services\Characters\AppearanceService;
use App\Services\Entity\CopyService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Database\Eloquent\Model;

class SaveService
{
    use CampaignAware;
    use UserAware;
    use RequestAware;
    use EntityAware;

    protected Model|MiscModel $model;

    public function __construct(
        protected CopyService $copyService,
        protected AttributeService $attributeService
    ) {}

    public function model(Model|MiscModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function create(array $data, string $class): Model
    {
        /** @var Character|MiscModel|Model $model */
        $model = app()->make($class);
        $this->model = $model->create($data);

        $this
            ->events()
            ->copy()
            ->related();

        return $this->model;
    }

    public function update(array $data): Model
    {
        $this->model->update($data);
        $this->model->crudSaved();

        $this->updateEntity();

        return $this->model;
    }

    protected function updateEntity(): void
    {
        $this->entity->name = $this->model->name;
        $this->entity->is_private = $this->model->is_private;
        $this->entity->crudSaved();

        // If the child was changed but nothing changed on the entity, we still want to trigger an update
        if ($this->model->wasChanged() && ! $this->entity->wasChanged()) {
            $this->entity->touch();
        }
    }

    protected function events(): self
    {
        if (method_exists($this->model, 'crudSaved')) {
            $this->model->crudSaved();
        }
        return $this;
    }

    protected function copy(): self
    {
        if ($this->model instanceof Bookmark || !$this->model->entity) {
            return $this;
        }
        $this->model->entity->crudSaved();
        // Weird hack for prod issues
        if (! $this->model->entity->child) {
            $this->model->entity->setRelation('child', $this->model);
        }

        // First, copy stuff like posts, since we might replace attribute mentions next
        $this->copyService
            ->entity($this->model->entity)
            ->request($this->request)
            ->fromId()
            ->copy();

        if (! $this->user->can('attributes', $this->model->entity)) {
            return $this;
        }
        $this->attributeService
            ->campaign($this->campaign)
            ->entity($this->model->entity)
            ->save($this->request->get('attribute', []));

        // When copying an entity, the user probably wants to update all mentions of attributes to ones on the new entity.
        if (
            $this->request->has('replace_mentions') &&
            $this->request->filled('replace_mentions') &&
            $this->model->entity->isFillable('entry')) {
            $this->attributeService
                ->replaceMentions((int) $this->request->post('copy_source_id'));
        }

        return $this;
    }

    protected function related(): void
    {
        if (!property_exists($this->model, 'related') || empty($this->model->related)) {
            return;
        }
        foreach ($this->model->related as $related) {
            /** @var AppearanceService $service */
            $service = app()->make($related);
            $service->request($this->request)
                ->model($this->model)
                ->user($this->user)
                ->process();
        }
    }
}
