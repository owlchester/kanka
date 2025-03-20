<?php

namespace App\Services\Entity;

use App\Models\EntityLog;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Post;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostLoggerService
{
    use CampaignAware;
    use UserAware;

    protected array $logged = [];

    /** Track fields that are dirty for the current post */
    protected array $changes = [];

    protected EntityLog $log;

    protected Post $post;

    public function postDirty(Post $post): array
    {
        $dirty = $post->getDirty();
        $ignoredAttributes = ['created_at', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'];
        foreach ($dirty as $attribute => $value) {
            // If the model has this attribute as ignored for logs, skip it
            if (in_array($attribute, $ignoredAttributes)) {
                continue;
            }
            // We log the old value
            $value = $post->getOriginal($attribute);
            if (Str::endsWith($attribute, '_id')) {
                // Foreign? Try and get the related model
                $value = $this->getForeignOriginal($attribute, $value);
            }

            // If it's not an array, easy work
            if (! is_array($value)) {
                $this->changes[$attribute] = $value;

                continue;
            }

            // An array (config[, moons[) we need to store it differently
            foreach ($value as $k => $v) {
                $this->changes[$k] = $v;
            }
        }

        return $this->changes;
    }

    protected function getForeignOriginal(string $attribute, mixed $original): string
    {
        if (empty($original)) {
            return '';
        }

        try {
            if ($attribute == 'location_id') {
                $originalLocation = Location::where('id', $original)->first();
                if (! empty($originalLocation)) {
                    return (string) $originalLocation->name;
                }

                return '';
            }

            // Let's try based off of the attribute name
            $relationName = Str::before($attribute, '_id');
            $relationName = Str::camel($relationName);

            $relationClass = 'App\Models\\' . ucfirst($relationName);

            /** @var MiscModel $relationModel */
            $relationModel = new $relationClass;
            /** @var MiscModel $result */
            $result = $relationModel->where('id', $original)->firstOrFail();
            if ($result->name) {
                return $result->name;
            } else {
                // @phpstan-ignore-next-line
                return $result->code;
            }
        } catch (Exception $e) {
            Log::error('Issue with Logger', ['e' => $e->getMessage()]);

            return '';
        }
    }
}
