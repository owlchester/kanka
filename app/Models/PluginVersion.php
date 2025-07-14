<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

/**
 * Class PluginVersion
 *
 * @property int $id
 * @property int $plugin_id
 * @property string $uuid
 * @property string $version
 * @property string $entry
 * @property string $content
 * @property string $fonts
 * @property string $css
 * @property Carbon $updated_at
 * @property int $status_id
 * @property int $approved_by
 * @property Plugin $plugin
 * @property string|array $json
 */
class PluginVersion extends Model
{
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'json' => 'array',
    ];

    /**
     * Get the attributes (stored in the JSON)
     */
    public function getAttributesAttribute(): array
    {
        return Arr::get($this->json, 'attributes', []);
    }

    /**
     * Get the CSS (stored in the JSON)
     */
    public function getCssAttribute(): string
    {
        return Arr::get($this->json, 'css', '');
    }

    /**
     * Get the translations (stored in the JSON)
     */
    public function getTranslationsAttribute(): array
    {
        return Arr::get($this->json, 'translations', []);
    }

    public function css(): string
    {
        return (string) $this->css;
    }

    public function scopePublishedVersions(Builder $query, int $pluginCreator): Builder
    {
        if ($pluginCreator === auth()->user()->id) {
            return $query->whereIn('status_id', [1, 3]);
        }

        return $query->where('status_id', 3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\PluginVersionEntity, $this>
     */
    public function entities(): HasMany
    {
        return $this->hasMany(PluginVersionEntity::class);
    }

    /**
     * Determine if the current version is a draft
     */
    public function isDraft(): bool
    {
        return $this->status_id === 1;
    }
}
