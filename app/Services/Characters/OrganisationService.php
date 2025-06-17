<?php

namespace App\Services\Characters;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\OrganisationMember;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

class OrganisationService
{
    use UserAware;
    use RequestAware;

    protected Character $character;

    public function model(Character $character): self
    {
        $this->character = $character;
        return $this;
    }

    public function process(): void
    {
        // If the organisations array isn't provided, skip this feature. The crud interface will always provide one,
        // and the api calls will provide one if necessary.
        if (! $this->request->has('character_save_organisations')) {
            return;
        }

        $existing = [];
        /** @var OrganisationMember $org */
        foreach ($this->character->organisationMemberships()->has('organisation')->get() as $org) {
            $existing[$org->id] = $org;
        }

        $orgCount = 0;
        $organisations = (array) $this->request->post('organisations', []);
        $roles = new Collection($this->request->post('organisation_roles', []));
        $statuses = new Collection($this->request->post('organisation_statuses', []));
        $pins = new Collection($this->request->post('organisation_pins', []));
        $privates = new Collection($this->request->post('organisation_privates', []));

        // Prepare roles and permissions that a new (have no id) to properly map them with new organisations
        $newRoles = new Collection;
        foreach ($roles as $id => $role) {
            if (empty($id)) {
                $newRoles->push($role);
            }
        }

        $newStatuses = new Collection;
        foreach ($statuses as $id => $status) {
            if (empty($id)) {
                $newStatuses->push($status);
            }
        }

        $newPins = new Collection;
        foreach ($pins as $id => $pin) {
            if (empty($id)) {
                $newPins->push($pin);
            }
        }

        $newPrivates = new Collection;
        foreach ($privates as $id => $private) {
            if (empty($id)) {
                $newPrivates->push($private);
            }
        }

        foreach ($organisations as $key => $id) {
            if (empty($id)) {
                continue;
            }

            if (! empty($existing[$key])) {
                $model = $existing[$key];
                unset($existing[$key]);
            } else {
                $model = new OrganisationMember;
                $model->character_id = $this->character->id;
                EntityLogger::dirty('organisations', null);
            }
            $model->organisation_id = (int) $id;
            $model->role = $roles->has($key) ? $roles->get($key, '') : $newRoles->shift();
            $model->pin_id = (int) ($pins->has($key) ? $pins->get($key, '') : $newPins->shift());
            $model->status_id = (int) ($statuses->has($key) ? $statuses->get($key, '') : $newStatuses->shift());
            if ($this->request->has('organisation_privates')) {
                $model->is_private = $privates->has($key) ? $privates->get($key, false) : $newPrivates->shift();
            } else {
                $model->is_private = false;
            }
            if ($model->save()) {
                $orgCount++;
            }
        }

        foreach ($existing as $id => $model) {
            $model->delete();
            EntityLogger::dirty('organisations', null);
        }
    }
}
