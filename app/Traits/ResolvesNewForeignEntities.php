<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ResolvesNewForeignEntities
{
    use CreatesEntityFromName;

    /**
     * Declare which FK fields may receive a new entity name as their value.
     * Return an array of field_name => [ModelClass, entityTypeId].
     * Override this method directly for fields that don't follow the {snake}_id convention.
     *
     * @return array<string, array{string, int}>
     */
    protected function newEntityFields(): array
    {
        $fields = [];
        foreach ($this->foreignEntityFields ?? [] as $field) {
            $key = str_replace('_id', '', $field);
            $fields[$field] = ['App\\Models\\' . Str::studly($key), config("entities.ids.{$key}")];
        }

        return $fields;
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

            $name = Str::startsWith($value, 'new:') ? Str::substr($value, 4) : $value;

            // Always replace the string — with the new ID on success, or null so
            // the nullable rule can pass cleanly rather than failing on "integer".
            $resolved = $this->createNewForeignEntity($name, $classname, $entityTypeId);
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

    protected function createNewForeignEntity(string $value, string $classname, int $entityTypeId): ?int
    {
        // AJAX calls are validation-only pre-flight requests; skip creation to avoid duplicates.
        if (empty($value) || request()->ajax()) {
            return null;
        }

        $campaign = CampaignLocalization::getCampaign();
        $entityType = $campaign->getEntityTypes()->firstWhere('id', $entityTypeId);

        return $this->createModelFromName($value, $classname, $entityType, $campaign);
    }
}
