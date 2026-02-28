<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Models\MiscModel;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

trait ResolvesNewForeignEntities
{
    /**
     * Declare which FK fields may receive a new entity name as their value.
     * Return an array of field_name => [ModelClass, entityTypeId].
     *
     * @return array<string, array{string, int}>
     */
    protected function newEntityFields(): array
    {
        return [];
    }

    protected function prepareForValidation(): void
    {
        $this->resolveNewForeignEntities($this);
    }

    /**
     * Resolve any typed-in entity names in FK fields into real IDs on the given request.
     * Called directly by EditController when form requests are not DI-injected.
     */
    public function resolveNewForeignEntities(Request $request): void
    {
        foreach ($this->newEntityFields() as $field => [$classname, $entityTypeId]) {
            $value = $request->input($field);
            if (empty($value) || is_numeric($value)) {
                continue;
            }

            // Always replace the string — with the new ID on success, or null so
            // the nullable rule can pass cleanly rather than failing on "integer".
            $resolved = $this->createNewForeignEntity(mb_trim(Purify::clean($value)), $classname, $entityTypeId);
            $request->merge([$field => $resolved]);
        }
    }

    /**
     * Return only the fields from newEntityFields() that were resolved during prepareForValidation().
     * Used by EditController to sync resolved IDs back into the original request.
     *
     * @return array<string, mixed>
     */
    public function resolvedFields(): array
    {
        return array_intersect_key($this->all(), $this->newEntityFields());
    }

    protected function createNewForeignEntity(string $name, string $classname, int $entityTypeId): ?int
    {
        // AJAX calls are validation-only pre-flight requests; skip creation to avoid duplicates.
        if (empty($name) || request()->ajax()) {
            return null;
        }

        $ids = $this->resolveNewModels([$name], $classname, $entityTypeId, CampaignLocalization::getCampaign()->id);

        return $ids[0] ?? null;
    }

    /**
     * For each value in the array, if it is a non-numeric string, create a new entity with that name.
     * Returns an array of model IDs ready for relationship syncing.
     *
     * @param  array<mixed>  $values
     * @return array<int>
     */
    public function resolveNewModels(array $values, string $classname, int $entityTypeId, int $campaignId): array
    {
        $canCreate = null;
        $resolved = [];

        foreach ($values as $value) {
            if (is_numeric($value)) {
                $resolved[] = (int) $value;

                continue;
            }

            $name = mb_trim(Purify::clean($value));
            if (empty($name)) {
                continue;
            }

            if ($canCreate === null) {
                $campaign = CampaignLocalization::getCampaign();
                $entityType = $campaign->getEntityTypes()->firstWhere('id', $entityTypeId);
                $canCreate = auth()->user()->can('create', [$entityType, $campaign]);
            }

            if (! $canCreate) {
                continue;
            }

            /** @var MiscModel $model */
            $model = new $classname([
                'name' => $name,
                'campaign_id' => $campaignId,
                'is_private' => false,
            ]);
            $model->saveQuietly();
            $model->createEntity();
            $resolved[] = $model->id;
        }

        return $resolved;
    }
}
