<?php

namespace App\Services\Entity;

use App\Enums\EntityAssetType;
use App\Enums\Visibility;
use App\Traits\EntityAware;
use App\Traits\RequestAware;

class AliasService
{
    use EntityAware;
    use RequestAware;

    /**
     * Save aliases submitted from the entity create/edit form.
     *
     * Reads the `aliases` JSON field from the request. Each item has shape:
     *   { id: int, name: string, visibility: string }
     *
     * Negative IDs indicate new aliases; positive IDs are existing ones.
     * Because EntityAsset uses VisibilityIDScope, admin-only aliases are
     * invisible to non-admin users — the scope automatically protects them
     * from being accidentally deleted or modified.
     */
    public function save(): void
    {
        $aliases = json_decode($this->request->input('aliases', '[]'), true) ?? [];

        $this->saveAliases($aliases);
    }

    /**
     * @param  array<int, array{id: int|string, name: string, visibility: string}>  $aliases
     */
    private function saveAliases(array $aliases): void
    {
        $submittedIds = collect($aliases)
            ->filter(fn (array $a): bool => (int) $a['id'] > 0)
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        // Delete visible aliases that the user removed from the list.
        // VisibilityIDScope ensures admin-only aliases are excluded here,
        // so they are never deleted by non-admin users.
        $this->entity->aliases()
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($aliases as $data) {
            $id = (int) $data['id'];
            $name = $data['name'];
            $visibility = $this->visibilityFromString($data['visibility'] ?? 'all');

            if ($id <= 0) {
                $this->entity->assets()->create([
                    'type_id' => EntityAssetType::alias,
                    'name' => $name,
                    'visibility_id' => $visibility,
                ]);
            } else {
                // VisibilityIDScope prevents non-admin users from updating
                // aliases they cannot see.
                $this->entity->aliases()
                    ->where('id', $id)
                    ->update([
                        'name' => $name,
                        'visibility_id' => $visibility,
                    ]);
            }
        }
    }

    private function visibilityFromString(string $visibility): Visibility
    {
        return match ($visibility) {
            'admin' => Visibility::Admin,
            'admin-self' => Visibility::AdminSelf,
            'self' => Visibility::Self,
            'members' => Visibility::Member,
            default => Visibility::All,
        };
    }
}
