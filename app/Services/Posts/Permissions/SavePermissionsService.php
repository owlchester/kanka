<?php

namespace App\Services\Posts\Permissions;

use App\Models\PostPermission;
use App\Traits\PostAware;
use App\Traits\RequestAware;

class SavePermissionsService
{
    use PostAware;
    use RequestAware;

    public function save()
    {
        $existing = $parsed = [];
        foreach ($this->post->permissions as $perm) {
            $existing[$perm->isUser() ? 'u_' . $perm->user_id : 'r_' . $perm->role_id] = $perm;
        }

        $users = (array) $this->request->post('perm_user', []);
        $perms = (array) $this->request->post('perm_user_perm', []);
        $dirty = false;

        foreach ($users as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'u_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = (int) $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            } elseif (! in_array($existingKey, $parsed)) {
                PostPermission::create([
                    'post_id' => $this->post->id,
                    'user_id' => $user,
                    'permission' => $perms[$key],
                ]);
                $parsed[] = $existingKey;
                $dirty = true;
            }
        }

        $roles = (array) $this->request->post('perm_role', []);
        $perms = (array) $this->request->post('perm_role_perm', []);

        foreach ($roles as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'r_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = (int) $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            } elseif (! in_array($existingKey, $parsed)) {
                PostPermission::create([
                    'post_id' => $this->post->id,
                    'role_id' => $user,
                    'permission' => $perms[$key],
                ]);
                $dirty = true;
                $parsed[] = $existingKey;
            }
        }

        // Cleanup permissions that are no longer used
        foreach ($existing as $oldPermission) {
            $oldPermission->delete();
            $dirty = true;
        }
    }
}
