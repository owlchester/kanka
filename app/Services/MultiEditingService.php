<?php


namespace App\Services;


use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\Campaign;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\EntityUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MultiEditingService
{
    /** @var Model */
    protected $model;

    /** @var User */
    protected $user;

    /**
     * @param Model $model
     * @return $this
     */
    public function model(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Check for users that are currently editing an entity
     */
    public function users(): array
    {
        $data = [];
        $users = $this->model
            ->editingUsers()
            ->where('type_id', EntityUser::TYPE_KEEPALIVE)
            ->where('entity_user.updated_at', '>=', Carbon::now()->subMinutes(10))
            ->where('user_id', '!=', $this->user->id)
            ->withPivot('created_at')
            ->get();

        foreach ($users as $user) {
            $data[$user->id] = $user;
        }

        return $data;
    }

    /**
     * Check if the user is editing the entity
     * @return bool
     */
    public function isEditing(): bool
    {
        return $this->model->editingUsers()
            ->where('type_id', EntityUser::TYPE_KEEPALIVE)
            ->where('user_id', $this->user->id)
            ->count() !== 0;
    }

    /**
     * Set the user as editing an entity
     * @return $this
     */
    public function edit(): self
    {
        $model = new EntityUser();
        if ($this->model instanceof EntityNote) {
            $model->post_id = $this->model->id;
        } elseif ($this->model instanceof Campaign) {
            $model->campaign_id = $this->model->id;
        } elseif ($this->model instanceof TimelineElement) {
            $model->timeline_element_id = $this->model->id;
        } elseif ($this->model instanceof QuestElement) {
            $model->quest_element_id = $this->model->id;
        } elseif ($this->model instanceof Entity) {
            $model->entity_id = $this->model->id;
        }
        $model->user_id = $this->user->id;
        $model->type_id = EntityUser::TYPE_KEEPALIVE;
        $model->save();
        return $this;
    }

    /**
     * Remove the user as editing the entity
     * @return $this
     */
    public function finish(): self
    {
        if ($this->model instanceof EntityNote) {
            $id = 'post_id';
        } elseif ($this->model instanceof Campaign) {
            $id = 'campaign_id';
        } elseif ($this->model instanceof TimelineElement) {
            $id = 'timeline_element_id';
        } elseif ($this->model instanceof QuestElement) {
            $id = 'quest_element_id';
        } elseif ($this->model instanceof Entity) {
            $id = 'entity_id';
        }

        $models = EntityUser::userID($this->user->id)
            ->keepAlive()
            ->where($id, $this->model->id)
            ->get();
        foreach ($models as $model) {
            $model->delete();
        }

        return $this;
    }

    /**
     * Touch the editing entry in the db
     * @return $this
     */
    public function keepAlive(): self
    {
        $pulse = $this->model->editingUsers()
            ->where('type_id', EntityUser::TYPE_KEEPALIVE)
            ->where('user_id', $this->user->id)
            ->first();

        if ($pulse) {
            $pulse->touch();
        }

        return $this;
    }

    public function confirm(): void
    {
        if (!$this->isEditing()) {
            $this->edit();
        }
    }
}
