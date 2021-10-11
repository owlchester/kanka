<?php


namespace App\Services\Entity;


use App\Models\Entity;
use App\Models\EntityUser;
use App\User;
use Carbon\Carbon;

class MultiEditingService
{
    /** @var Entity */
    protected $entity;

    /** @var User */
    protected $user;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
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
        $users = $this->entity
            ->users()
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
        return $this->entity->users()
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
        $model->entity_id = $this->entity->id;
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
        $models = EntityUser::userID($this->user->id)
            ->keepAlive()
            ->where('entity_id', $this->entity->id)
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
        $pulse = $this->entity->users()
            ->where('type_id', EntityUser::TYPE_KEEPALIVE)
            ->where('user_id', $this->user->id)
            ->first();

        if ($pulse) {
            $pulse->touch();
        }

        return $this;
    }
}
