<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

/**
 * Class PluginVersion
 * @package App\Models
 *
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
    /** @var Entity */
    protected Entity $entity;

    /** @var Collection|Attribute[] */
    protected $entityAttributes;

    protected array $templateAttributes = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'json' => 'array'
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

    /**
     * Get the translations (stored in the json)
     * @return array
     */
    public function getTranslationsAttribute(): array
    {
        return Arr::get($this->json, 'translations', []);
    }

    /**
     * @param Entity $entity
     * @return string|string[]|null
     */
    public function content(Entity $entity)
    {
        // Let people update their plugins before using the new syntax
        if ($this->updated_at->gt('2021-03-30 17:00:00')) {
            return $this->renderBlade($entity);
        }

        $this->entityAttributes = $entity->allAttributes;
        $html = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            $name = (string) $matches[1];
            return $this->attribute($name);
        }, $this->content);


        // Replace < and > in logical blocks
        //$html = str_replace(['&lt;', '&gt;'], ['<', '>'], $html);

        //dump($html);
        //return $html;

        // If-Else condition

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@endif`si', function ($matches) {
            return $this->ifBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@else(.*?)@endif`si', function ($matches) {
            return $this->ifElseBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@empty\((.*?)\)(.*?)@endempty`si', function ($matches) {
            return (string) $this->emptyBlock($matches);
        }, $html);
        $html = preg_replace_callback('`@notempty\((.*?)\)(.*?)@endnotempty`si', function ($matches) {
            return (string) !$this->emptyBlock($matches);
        }, $html);

        return $html;
    }

    /**
     * @return string
     */
    public function css(): string
    {
        $css = (string) $this->css;
        return $css;
    }

    /**
     * The new rendering engine using Blade
     * @param Entity $entity
     * @return false|string
     */
    protected function renderBlade(Entity $entity)
    {
        $html = $this->content;
        $html = str_replace(['&lt;', '&gt;', '&amp;&amp;'], ['<', '>', '&&'], $html);

        // Loop on every variable to be rendered in the
        $html = preg_replace_callback('`\{(.*?[^\!])\}`i', function ($matches) {
            $name = trim((string) $matches[1]);
            // If it's a {{ }} case, nothing more to do
            if (Str::startsWith($name, '{')) {
                return '{' . $name . ' }';
            }

            // However, if it's an attribute being generated à la ${"member$i"}, we need to skip it
            if (Str::startsWith($name, '"') && Str::contains($name, '$')) {
                return '{' . $name . '}';
            }
            $this->templateAttributes[$name] = null;
            return '{{ $' . $name . ' }}';
        }, $html);

        // Blacklisted commands
        $html = str_replace([
            '@php', '@dd', '@inject', '@yield', '@section', '@auth', '@guest', '@env', '@once', '@push', '@csrf',
            '@include', '\Illuminate\\'
        ], [
            '', '', '', '', '', '', '', '', '', '', '', '', ''
        ], $html);

        // Remove more blacklisted stuff than can go unnoticed
        $html = preg_replace('`dd\((.*?)\)`i', '', $html);
        $html = preg_replace('`config\((.*?)\)`i', '', $html);

        // Replace translation calls with blade echoes
        $html = preg_replace_callback('`\@i18n\(\'(.*?[^)])\'\)`i', function ($matches) {
            return '{{ trans("' . $matches[1] . '") }}';
        }, $html);

        $this->loadTranslations();

        $html = Blade::compileString($html);

        list($data, $ids, $checkboxes) = $this->prepareBladeData($entity);

        $html = preg_replace_callback('`\@liveAttribute\(\'(.*?[^)])\'\)`i', function ($matches) use ($data, $ids, $checkboxes) {
            $attr = trim((string) $matches[1]);
            if (!isset($data[$attr])) {
                return $matches[0];
            }
            $value = $data[$attr];
            if (in_array($attr, $checkboxes)) {
                if ($data[$attr] === 'on') {
                    $value = '<i class="fa-solid fa-check"></i>';
                } else {
                    $value = '<i class="fa-solid fa-times"></i>';
                }
            }
            return '<span class="live-edit" data-id="' . $ids[$attr] . '">' . $value . '</span>';
        }, $html);
        //dd($html);

        $obLevel = ob_get_level();
        ob_start() and extract($data, EXTR_SKIP);

        $errors = null;

        try {
            eval('?' . '>' . $html);
            $blade = ob_get_clean();
            return $blade;
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();
            //throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();

            //throw new FatalThrowableError($e);
        }
        return '<div class="alert alert-danger">
            ' . __('attributes/templates.errors.marketplace.rendering') . (!empty($errors) ?
                '<br /><br />' . __('attributes/templates.errors.marketplace.hint') . ': ' . $errors . ' (line ' . $e->getLine() . ')' : null) . '
        </div>';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function attribute(string $name): string
    {
        /** @var Attribute|null $attr */
        $attr = $this->entityAttributes->where('name', $name)->first();
        if (!empty($attr)) {
            if ($attr->isText()) {
                return nl2br($attr->mappedValue());
            }
            return $attr->mappedValue();
        }

        return '<i class="missing-attribute">' . $name . '</i>';
    }

    /**
     * If Else block
     * @param array $matches
     * @return mixed
     */
    protected function ifElseBlock(array $matches)
    {
        // Test on a missing attribute always returns false
        $trimmed = trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return $matches[3];
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        } else {
            return $matches[3];
        }
    }

    /**
     * If block
     * @param array $matches
     * @return mixed|null
     */
    protected function ifBlock(array $matches)
    {
        // If there is an else in the block, let the if-else block handle it later
        if (Str::contains($matches[2], '@else')) {
            return $matches[0];
        }
        // Test on a missing attribute always returns false
        $trimmed = trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return null;
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<', '&lt;', '&gt;'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        }
        return null;
    }

    /**
     * Evaluate a condition
     * @param string $condition
     * @return bool
     */
    protected function evaluateCondition(string $condition): bool
    {
        // >=
        if (Str::contains($condition, '&gt;=')) {
            $segments = explode('&gt;=', $condition);
            return (int) trim($segments[0]) >= (int) trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;=')) {
            $segments = explode('&lt;=', $condition);
            return (int) trim($segments[0]) <= (int) trim($segments[1]);
        } elseif (Str::contains($condition, '&gt;')) {
            $segments = explode('&gt;', $condition);
            return (int) trim($segments[0]) > (int) trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;')) {
            $segments = explode('&lt;', $condition);
            return (int) trim($segments[0]) < (int) trim($segments[1]);
        } elseif (Str::contains($condition, '=')) {
            $segments = explode('=', $condition);
            return trim($segments[0]) == trim($segments[1]);
        }
        return false;
    }

    protected function emptyBlock(array $matches)
    {
        $condition = trim($matches[1]);
        if (Str::contains($condition, '<i class="missing">')) {
            return false;
        } elseif (empty($condition)) {
            return false;
        }
        return true;
    }

    /**
     * Add the plugin's translations to memory
     * @return void
     */
    protected function loadTranslations(): void
    {
        // Always add the user's locale + en as a fallback
        $userLocale = auth()->user()->locale;
        $locales = [$userLocale, 'en'];

        foreach ($this->getTranslationsAttribute() as $translation) {
            if (!in_array($translation['locale'], $locales)) {
                continue;
            }
            $lines['*.' . $translation['base']] = $translation['translation'];

            app('translator')->addLines($lines, $userLocale);
        }
    }

    /**
     * Prepare all the attributes of the entity to be accessible in blade
     * @param Entity $entity
     * @return array
     */
    protected function prepareBladeData(Entity $entity): array
    {
        $data = [];
        $ids = [];
        $checkboxes = [];
        $this->entityAttributes = $entity->allAttributes;
        $allAttributes = [];
        foreach ($this->entityAttributes as $attr) {
            $name = str_replace(' ', '', $attr->name);
            if (Str::contains($name, '[range:')) {
                $name = Str::before($name, '[range:');
            }
            $data[$name] = $attr->mappedValue();
            $ids[$name] = $attr->id;
            if ($attr->isText()) {
                $data[$name] = nl2br($data[$name]);
            } elseif ($attr->isCheckbox()) {
                $checkboxes[] = $name;
            }
            //dump('mapping ' . $name . ' to ' . $attr->mappedValue());

            // Cleanup the name for ranged values
            $allAttributes[$name] = $data[$name];
            unset($this->templateAttributes[$name]);
        }

        // We need this for some blade directives like foreach
        $data['__env'] = app(\Illuminate\View\Factory::class);
        $data['attributes'] = $allAttributes;

        // Add any missing attributes to be accessible in blade
        foreach ($this->templateAttributes as $name) {
            $data[$name] = null;
        }

        return [$data, $ids, $checkboxes];
    }

    /**
     * @param Builder $query
     * @param int $pluginCreator
     * @return Builder
     */
    public function scopePublishedVersions(Builder $query, int $pluginCreator)
    {
        if ($pluginCreator === auth()->user()->id) {
            return $query->whereIn('status_id', [1, 3]);
        }
        return $query->where('status_id', 3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entities()
    {
        return $this->hasMany(PluginVersionEntity::class);
    }

    /**
     * Determine if the current version is a draft
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->status_id === 1;
    }
}
