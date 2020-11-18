<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class PluginVersion
 * @package App\Models
 *
 * @property int $plugin_id
 * @property string $uuid
 * @property string $version
 * @property string $entry
 * @property string $content
 * @property int $approved_by
 * @property Plugin $plugin
 */
class PluginVersion extends Model
{
    /** @var Entity */
    protected $entity;

    /** @var Attribute[] */
    protected $entityAttributes;

    /**
     * @var string[]
     */
    protected $casts = [
        'json' => 'Array'
    ];

    /**
     * Get the attributes (stored in the json)
     * @return array
     */
    public function getAttributesAttribute(): array
    {
        return Arr::get($this->json, 'attributes', []);
    }

    /**
     * Get the css (stored in the json)
     * @return string
     */
    public function getCssAttribute(): string
    {
        return Arr::get($this->json, 'css', '');
    }

    public function content(Entity $entity)
    {
        $this->entityAttributes = $entity->attributes()->get();
        $html = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            $name = (string)$matches[1];
            return $this->attribute($name);
        }, $this->content);

        return $html;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function attribute(string $name): string
    {
        /** @var Attribute $attr */
        $attr = $this->entityAttributes->where('name', $name)->first();
        if (!empty($attr)) {
            return $attr->mappedValue();
        }

        return $name;
    }
}
