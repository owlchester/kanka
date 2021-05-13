<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Administrator',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Normal User',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'translator']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Translator',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'api']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Api',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'patreon']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Patreon',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'partner']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => 'Partner',
                ])->save();
        }
    }
}
